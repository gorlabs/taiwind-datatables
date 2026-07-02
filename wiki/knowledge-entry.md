---
type: "gotcha"
topic: "tailwind-datatables X-Ray: Mevcut Mimari Keşif Raporu"
date: "2026-07-02"
status: active
---

# 🧠 Knowledge Entry: tailwind-datatables X-Ray — Mevcut Mimari Keşif Raporu

## 1. Çekirdek Yapı (Kod Dondurulmuş — Analiz)

### src/TailwindDatatablesServiceProvider.php — Sorumluluk Dağılımı
**Tek dosyada 4 sorumluluk:**
1. **View kaydı** (`loadViewsFrom` → `tailwind-datatables::datatables.*`)
2. **Config publish** (`gorlabs-tailwind-datatables-config`)
3. **CSS asset publish** (`tailwind-datatables-css` — yeni eklenen)
4. **Yajra HTML konfigürasyon zorlaması** (`Config::set('datatables-html.script', ...)` ve `Config::set('datatables-html.view', ...)`)

**Route/middleware yok** — paket herhangi bir rota kaydetmiyor, tamamen view + config + asset publish odaklı. Başka sınıf yok; tek `ServiceProvider` dosyası.

**YENİ EKLENEN KOD yorumu (satır 25):** CSS publish bloğu açıkça işaretlenmiş, bu major upgrade için dokunulması gereken alanlardan biri.

**⚠️ Kritik Tespit:** `Config::set('datatables-html.*')` satırları Yajra'nın kendi konfigürasyonunu **runtime'da eziyor**. Bu, kullanıcının kendi `config/datatables-html.php` dosyasında yaptığı değişiklikleri geçersiz kılar. Bu bir **gizli bağımlılık** ve upgrade'de daha şeffaf hale getirilmeli.

### composer.json — Versiyon Kısıtları
```json
{
  "php": "^8.2",
  "illuminate/support": "^10.0 || ^11.0 || ^12.0",
  "yajra/laravel-datatables-oracle": "^10.0 || ^11.0 || ^12.0",
  "yajra/laravel-datatables-buttons": "^10.0 || ^11.0 || ^12.0",
  "yajra/laravel-datatables-html": "^10.0 || ^11.0 || ^12.0"
}
```
- **Laravel 10/11/12** desteği mevcut → geniş uyumluluk.
- **Yajra 10/11/12** triple-versiyon desteği.
- **require-dev yok** — test altyapısı hiç kurulmamış.
- **type: "laravel-package"** — doğru.

---

## 2. Blade-Kilidi Tespiti (Madde 1 — LA İhlali Riski)

### resources/views/datatables/table.blade.php (3 satır)
```blade
<div {{ $attributes->except('class') }}>
    {!! $dataTable->table(['class' => ...]) !!}
</div>
```
- Saf **render** — iş mantığı yok. Yajra'nın `$dataTable->table()` HTML'ini sarar. ✅ LA uyumlu.

### resources/views/datatables/scripts.blade.php (11 satır)
`<script>` etiketi var ama içi **yorum satırı + boş**. İş mantığı sıfır. ✅ LA uyumlu.

### resources/views/datatables/form.blade.php (39 satır)
- **Alpine.js `x-data` + `x-model`** kullanıyor.
- Sadece **form alanları** (title, content, is_published, published_at) + butonlar.
- CRUD mantığı `postForm` Alpine bileşeninde (`crud-datatable.js` içinde).
- **İş mantığı view'a sızmamış** — sadece UI katmanı. ✅ LA uyumlu.

**Sonuç:** Blade dosyaları **temiz**. İş mantığı backend controller + JS'de.

---

## 3. JavaScript Mimari Tespiti (Vanilla mı, jQuery mi, Alpine mi?)

### resources/js/crud-datatable.js (544 satır)
**Temel: Vanilla JS + jQuery (DataTables zorunlu kılıyor) + Alpine.js**
- **jQuery**: DataTables initialization (`$('#id').DataTable()`), DataTables API çağrıları.
- **Alpine.js**: `registerGorlabsDatatablesAlpineComponents()` ile 4 Alpine component kaydediyor:
  - `postForm` — form state yönetimi
  - `globalModal` — modal aç/kapa
  - `app` — edit-item / delete-item event listener'ları
  - `crudDataTable` — DataTables konfigürasyon + AJAX + lifecycle
- **Vanilla**: Global `window.GorlabsDatatables` namespace, render fonksiyonları (date, statusBadge, image, truncateText, actions).
- **Bağımlılıklar**: dayjs, SweetAlert2 (Swal), jQuery, DataTables.net.

**⚠️ Çakışma Riski:** 
- Livewire stack'te `app.js` içinde `Alpine.start()` zaten çağrılıyor. 
- Vue stack'te `resources/js/app.js` sonunda `Alpine.start()` manuel çağrılıyor.
- **İkinci bir `Alpine.start()` çağrısı çakışma yaratabilir.** 
- `postForm`, `post-form.js` içinde **hem export edilip Alpine.data ile kaydediliyor** hem de crud-datatable.js içinde tekrar `AlpineInstance.data('postForm', postForm)` ile kaydediliyor → **çift kayıt**.

### resources/js/post-form.js (83 satır)
- `Alpine.data('postForm', postForm)` ile kendini kaydediyor.
- **Aynı bileşen** crud-datatable.js içinde de `AlpineInstance.data('postForm', postForm)` ile kaydediliyor.
- `submitForm()` metodu hard-coded URL (`/posts`, `/posts/${id}`) kullanıyor — **configurable değil**.

---

## 4. Config Analizi (gorlabs-tailwind-datatables.php)

**Kapsam:**
- `defaults.dom` → Tailwind-uyumlu DOM yapısı
- `defaults.buttons` → export butonları (excel, csv, pdf, print, colvis)
- `defaults.language.url` → Türkçe dil dosyası (CDN)
- `views.table`, `views.scripts` → Blade view yolları
- `assets.js`, `assets.css` → asset yolları
- `render_options` → date_format (DD.MM.YYYY HH:mm), text_truncate_length, status_badges
- `theme_colors` → Tailwind renk sınıfları

**⚠️ Stack-spesifik varsayım:**
- `language.url` → **Türkçe hard-coded** (İngilizce stack'lerde sorun).
- `render_options.date_format` → **Türkçe format** (DD.MM.YYYY).
- Status badge text'leri (`published` → "Yayınlandı", `draft` → "Taslak") **Türkçe hard-coded**.
- **Stack-agnostic olması için** bu değerlerin kullanıcı tarafından override edilebilir olması gerekir, ancak crud-datatable.js içindeki render fonksiyonları bu config'i **okumuyor**, kendi varsayılanlarını kullanıyor.

---

## 5. examples/livewire vs examples/vue — Stack-Agnostic mi, Hile mi?

**Kesin Tespit:** Bu **stack-agnostic değil**, sadece **demo/integration örneği**.

- Her iki örnek de paketin **Blade view'larını (form.blade.php)** kullanıyor.
- Livewire örneği: Blade layout içinde `x-data="crudDataTable({...})"` ile Alpine kullanıyor.
- Vue örneği: Vue component içinde `onMounted` ile DataTables'ı manuel başlatıyor, **aynı Blade form view'ını modal içine yüklüyor**.
- **İkisi de aynı Blade form'u kullanıyor** — yani paket temelde **Blade render ediyor**, örnekler sadece "Blade'ı Livewire layout'u / Vue sayfası içine gömme" yöntemini gösteriyor.

**Sonuç:** 
- `table.blade.php` ve `scripts.blade.php` her iki stack'te de aynı.
- `form.blade.php` her iki stack'te de **Blade view olarak** kullanılıyor — Vue için `.vue` bileşeni yok.
- Vue örneğinde form, Blade view fetch edilip `modalContentArea.innerHTML` ile DOM'a enjekte ediliyor (**Blade-to-Vue bridge** — temiz değil).
- **Upgrade'de Vue için gerçek bir `.vue` bileşeni yazılması gerekebilir.**

---

## 6. CHANGELOG ve Versiyon

**Mevcut Versiyon:** `1.0.0` (2024-07-08)
- İlk sürüm, initial release.
- **SemVer** kurallarına uygun.
- Henüz yama/minor/major güncellemesi yok.

**Upgrade İzlenimi:**
- Mevcut yapıda **temel Blade kırılımı yok** — LA ihlali tespit edilmedi.
- Config override, çift Alpine kaydı, hard-coded Türkçe değerler gibi **minor iyileştirmeler** var.
- Ancak Vue stack'te Blade-to-Vue bridge'i kaldırıp gerçek Vue bileşeni yapmak **major değişiklik** gerektirebilir.
- CSS publish ve Config::set zorlaması **minor** olarak geçilebilir.
- **İlk izlenim:** Upgrade `v1.1.0` (minor) olarak başlayabilir, Vue-native bileşen eklentisi `v2.0.0` (major) gerektirir.

---

## 7. Dokümantasyon Farkı (docs/en vs docs/tr)

### Eşleşen Dosyalar:
| Konu | docs/en | docs/tr | Durum |
|------|---------|---------|-------|
| Giriş/README | README.md (kök) | giris.md | ✅ Eşleşiyor |
| Livewire Kurulum | setup-livewire.md | kurulum-livewire.md | ✅ İçerik aynı, dil farkı |
| Vue Kurulum | setup-vue.md | kurulum-vue.md | ✅ İçerik aynı, dil farkı |
| Temel Kullanım | basic-usage.md | temel-kullanim.md | ⚠️ İkisi de boş (0 satır) |
| Kolon Özelleştirme | column-customization.md | kolon-ozellestirme.md | ⚠️ İkisi de mevcut değil (404) |

**Tespitler:**
- **basic-usage.md** ve **temel-kullanim.md** dosyaları var ama **boş** (okuma sıfır satır döndü). Upgrade'de doldurulmalı.
- **column-customization.md** ve **kolon-ozellestirme.md** dosyaları **hiç yok** (404). Oluşturulmalı.
- **setup-livewire** ve **kurulum-livewire** arasında içerik farkı yok — sadece dil.
- **setup-vue** ve **kurulum-vue** arasında içerik farkı yok — sadece dil.
- **README.md** (EN) ve **giris.md** (TR) arasında da içerik farkı yok.

**Sonuç:** Upgrade'de:
- `docs/en/basic-usage.md` ve `docs/tr/temel-kullanim.md` **doldurulmalı**.
- `docs/en/column-customization.md` ve `docs/tr/kolon-ozellestirme.md` **oluşturulmalı**.
- Var olan dosyalar sadece lokalizasyon farkıyla taşınabilir.

---

## Özet Tablosu (Karar Noktaları)

| # | Tespit | Etki | Önerilen Aksiyon |
|---|--------|------|-----------------|
| 1 | `Config::set('datatables-html.*')` runtime override | Gizli bağımlılık | Servis sağlayıcıdan kaldır, kullanıcıya bırak |
| 2 | Türkçe hard-coded değerler (config + JS) | Stack-agnostic değil | Config'den okunabilir hale getir |
| 3 | `postForm` Alpine component **çift kayıt** | Çakışma riski | Tek kayıt noktasına indirge |
| 4 | Vue stack Blade form fetch ediyor (Blade-to-Vue bridge) | Temiz değil, Vue-native bileşen yok | Gerçek `.vue` bileşeni yaz |
| 5 | `docs/en/basic-usage.md` ve `column-customization.md` boş/eksik | Eksik dokümantasyon | Doldur/oluştur |
| 6 | require-dev yok | Test altyapısı yok | PHPUnit + Orchestra kur |
| 7 | SemVer v1.0.0 — ilk sürüm | Upgrade kararı | Minor (1.1.0) veya Major (2.0.0) |