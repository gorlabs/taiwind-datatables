# 0002 - Yajra Config Opt-In + Çift Alpine Kaydı Düzelt + CI Matrix

## 🎯 Hedef
Plan 0001'de characterization test ile kilitlenen davranışları kontrollü şekilde iyileştir:
1. **Config::set('datatables-html.*') override'ı opt-in yap** — Mevcut davranışı (zorunlu override) koru, ama `config/gorlabs-tailwind-datatables.php`'ye `override_yajra_config: true` anahtarı ekle. `false` olursa override çalışmasın.
2. **Çift Alpine kaydını düzelt** — `postForm` Alpine component'i hem `post-form.js` hem `crud-datatable.js` içinde kaydediliyor. Tek kayıt noktasına indirge.
3. **CI matrix workflow dosyasını oluştur** — `.github/workflows/tests.yml`, 4 Laravel versiyonunu (10/11/12/13) ayrı PHP+Testbench kombinasyonlarıyla test edecek.

## Laravel Sürüm Desteği (Madde 15)
Laravel 10/11/12/13 — dördü birden. CI matrix ile hepsi doğrulanacak.

## 🧩 Etkilenecek Dosyalar

### 1. Config Opt-In
- `config/gorlabs-tailwind-datatables.php` → `override_yajra_config: true` anahtarı eklenecek (varsayılan true = mevcut davranış korunur)
- `src/TailwindDatatablesServiceProvider.php` → boot() içindeki `Config::set('datatables-html.*')` blokları, `config('gorlabs-tailwind-datatables.override_yajra_config', true)` kontrolüne alınacak
- `tests/Unit/ServiceProviderTest.php` → 2 yeni test:
  - `override_yajra_config: false` iken override çalışmaz (regresyon testi)
  - `override_yajra_config: true` iken override çalışır (mevcut davranış korunur)

### 2. Çift Alpine Kaydı Düzelt
- `resources/js/post-form.js` → `Alpine.data('postForm', postForm)` kaydı **KALDIRILACAK** (sadece `export const postForm` kalacak)
- `resources/js/crud-datatable.js` → `AlpineInstance.data('postForm', postForm)` zaten var, değişmeyecek
- `tests/Unit/AlpineRegistrationTest.php` (yeni) — **STATİK KAYNAK TARAMASI** (JS çalışma zamanı değil, dosya içeriğinde `Alpine.data('postForm'` string'inin kaç kez geçtiğini sayar). Bu bir "gerçek davranış testi" değil, **statik doğrulama**dır. Detaylar için aşağıdaki `## 🧪 AlpineRegistrationTest — Kapsam ve Sınırlamalar` bölümüne bak.

### 3. CI Matrix Workflow
- `.github/workflows/tests.yml` (yeni) — aşağıdaki matrix ile

```
jobs:
  test:
    strategy:
      matrix:
        laravel: [10, 11, 12, 13]
        include:
          - laravel: 10
            testbench: ^8.0
            php: 8.1
          - laravel: 11
            testbench: ^9.0
            php: 8.2
          - laravel: 12
            testbench: ^10.0
            php: 8.2
          - laravel: 13
            testbench: ^11.0
            php: 8.3   # ZORUNLU: Laravel 13 sadece PHP 8.3+
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: ${{ matrix.php }}
      - run: composer require --dev "orchestra/testbench:${{ matrix.testbench }}" --no-update
      - run: composer update --prefer-dist --no-progress
      - run: vendor/bin/phpunit
```

**⚠️ 0001 taslağındaki typo düzeltildi:** `orchestra/testbed` → `orchestra/testbench`

### 4. CHANGELOG.md — v1.1.0 Taslak Girdi
- `CHANGELOG.md` → v1.1.0 bloğu eklenecek. İçerik (bu plan + 0003'ün içeriği ayrı major olana kadar geçici):

```markdown
## [1.1.0] - 2026-07-02 (TASLAK — Plan 0002 + 0003 kapsamı)

### Added
- `override_yajra_config` config anahtarı (varsayılan: true). false yapılırsa
  `Config::set('datatables-html.*')` runtime override'ı devre dışı kalır.
- `.github/workflows/tests.yml` — CI matrix (Laravel 10/11/12/13, PHP 8.1/8.2/8.3).

### Changed
- `resources/js/post-form.js`: `Alpine.data('postForm', ...)` kaydı kaldırıldı.
  Kayıt artık sadece `crud-datatable.js` üzerinden yapılır.
```

**Not:** v1.1.0 minor sürümüdür çünkü hiçbir public API kırılmaz (override_yajra_config varsayılanı true = eski davranış aynen korunur). 0003'te yapılacak değişiklikler minor da kalabilir, major da — karar 0003 planında netleşecek. CHANGELOG bu noktada birleştirilebilir veya ayrılabilir; bu plan sadece taslağı başlatır.

### 5. Dokümantasyon Güncellemesi (docs/en/*.md, docs/tr/*.md)
- `docs/en/basic-usage.md` (şu an boş — 0001 tespiti) → "Configuration" alt bölümü eklenecek: `override_yajra_config` anahtarının ne işe yaradığı, varsayılan değeri (`true`), nasıl override edileceği.
- `docs/tr/temel-kullanim.md` (şu an boş) → aynı içerik Türkçe.
- Eğer bu dosyalar hâlâ boşsa (`file_get_contents` 0 satır döndüyse), başlık + açıklama ile doldurulacak. Plan 0001'deki tespit: "basic-usage.md ve temel-kullanim.md dosyaları var ama boş". Bu plan onları doldurarak 0001'den devralınan borcu kapatır.

### 6. Examples Kontrolü (Net Plan)
- `examples/livewire/resources/js/app.js` → **kesin kontrol:** varsa ikinci `Alpine.start()` çağrısı kaldırılır. Yoksa "kontrol edildi, çakışma yok" kaydı düşülür.
- `examples/vue/resources/js/app.js` → **kesin kontrol:** varsa ikinci `Alpine.start()` çağrısı kaldırılır. Yoksa "kontrol edildi, çakışma yok" kaydı düşülür.
- Sonuç: `wiki/knowledge-entry.md`'ye veya doğrudan bu planın altına bir "Examples Check" notu eklenir. Sessizce atlanmaz.

## 🧪 AlpineRegistrationTest — Kapsam ve Sınırlamalar

**Bu dosya BİR PHP BİRİM TESTİDİR, JS çalışma zamanı testi değildir.**

Ne yapar:
- `resources/js/post-form.js` ve `resources/js/crud-datatable.js` dosyalarını okur
- `Alpine.data('postForm'` string'inin her dosyadaki geçiş sayısını sayar
- Toplam geçiş sayısının **1** olduğunu doğrular (sadece `crud-datatable.js` içinde, `post-form.js` içinde değil)
- Eğer `post-form.js` hâlâ `Alpine.data('postForm', postForm)` içeriyorsa test başarısız olur

Neyi doğrulamaz:
- Alpine.js çalışma zamanında component'in gerçekten kayıtlı olup olmadığını
- İki farklı bundle'da (örneğin farklı webpack/Vite chunk'ları) kaydın duplicate edilip edilmediğini
- Tarayıcı konsolunda hata olup olmadığını

Bu nedenle:
- **Bu bir "gerçek davranış testi" (behavioral test) değildir, statik kaynak taramasıdır (static source scan).**
- assertion'u buna göre yazılır: `$this->assertEquals(1, $count, 'Alpine.data("postForm", ...) should appear exactly once across all JS source files');`
- Dosya yorum satırında ve test metodunda açıkça "STATIC SOURCE SCAN — does not verify runtime JS behavior" ibaresi bulunur.
- Madde 9 gereği: "gerçek test" iddiası taşımaz, sadece "kaynak kod yapısını doğrular" olarak etiketlenir.

**Gelecek notu:** Gerçek bir JS runtime testi (Jest/Vitest ile) 0004+ planında eklenebilir. Bu, `package.json`'a devDependency + test script + `resources/js/__tests__/` dizini gerektirir. Bu planın kapsamı dışındadır — bu planda sadece statik tarama ile "çift kayıt yok" garantisi verilir.

## 🌍 Çok Dilli Translation Kontrolü
- `override_yajra_config` yeni config anahtarı — çeviri gerektirmez (config anahtarı koddur).
- Alpine düzeltmesi UI string'lerini etkilemez.
- `docs/en/basic-usage.md` ve `docs/tr/temel-kullanim.md` güncelleneceği için çeviri kontrolü yapılacak: İngilizce içerik yazılır, Türkçe birebir çevrilir (fark olmamalı).

## ⚠️ failed_attempts Risk Analizi
- **Hata #001 (devralındı):** Testbench versiyon eşlemesi. CI matrix taslağı doğrulanmış tabloya göre yazıldı (0001'de düzeltildi).
- **AlpineRegistrationTest sınırlaması:** Statik tarama olduğu için JS runtime'da duplicate registration'ı yakalayamaz. Bu bilinçli bir karardır (scope sınırı), risk olarak kabul edilir ve dokümante edilir.
- **override_yajra_config:** Varsayılan `true` = eski davranış aynen korunur. `false` yapan kullanıcının kendi `config/datatables-html.php` ayarları yoksa Yajra varsayılanları kullanılır, Blade view'lar bozulabilir. Dokümantasyonda uyarı eklenecek.
- **Alpine kaydı değişikliği:** `post-form.js` içindeki `Alpine.data('postForm', postForm)` kaldırıldığında, eğer bir kullanıcı doğrudan `post-form.js`'i import edip bu satıra güveniyorsa kırılır. CHANGELOG'da belirtilecek, SemVer minor (non-breaking) olarak işaretlenecek çünkü public API değişmez (postForm hâlà export edilir ve crud-datatable.js üzerinden kaydedilir).

## Onay Kilidi
Baş Mimar'dan "Uygula" veya "APPROVED" emri gelmeden tek satır kod yazılmaz (Madde 5).