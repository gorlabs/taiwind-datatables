# React (Inertia) Native Bileşenleri (Plan 0006)

Bu doküman, Plan 0006 kapsamında Blade bridge yaklaşımına alternatif olarak eklenen React native bileşenlerini açıklar.

> **Not:** Blade bridge (form.blade.php'nin Alpine.js ile çalıştırıldığı orijinal yaklaşım) hâlâ tam desteklenmektedir ve değişmemiştir. Yeni React native bileşenler eklentiseldir ve isteğe bağlıdır.

## Genel Bakış

Paket şu anda `examples/react/` demo projesinde iki React JSX bileşeni içermektedir:

### DataTable.jsx
Sunucu taraflı sayfalama yapan veri tablosu bileşeni:
- Mevcut `/posts-data` AJAX endpoint'ine bağlanır (aynı Yajra DataTables endpoint'i)
- Sunucu taraflı sayfalama, arama ve sütun sıralama destekler
- CRUD işlemleri için `onEdit` ve `onDelete` callback'leri alır
- Native `fetch()` API kullanır (ek bağımlılık gerekmez)
- CRUD sonrası yenileme için `datatable-reload` custom event'ini dinler

### FormModal.jsx
Modal form bileşeni:
- `post` prop'u ile hem Create hem Edit işlemlerini yönetir (`null` = create, obje = edit)
- Mevcut `/posts` RESTful endpoint'lerine bağlanır (`POST` create, `PUT` update)
- Alan bazlı validasyon hatalarını her input altında gösterir
- `show`, `post`, `onClose` ve `onSaved` prop'larını kabul eder

## Demo Sayfası

`/posts-react-native` rotası, her iki bileşeni birleştiren `IndexReactNative.jsx` sayfasını render eder.

## Blade Bridge'e Göre Avantajlar

| Özellik | Blade Bridge (Orijinal) | React Native (Yeni) |
|---------|------------------------|---------------------|
| Form render | Blade view fetch → innerHTML | Native JSX template |
| Reactivity | Alpine.js x-model | React useState |
| Modal | Alpine globalModal | Native React bileşeni |
| Bundle | Alpine.initTree gerekli | Ek başlatma gerekmez |

## Kurulum

Bileşenler şu konumda bulunur:
```
examples/react/resources/js/Components/
```

Kendi React/Inertia uygulamanızda kullanmak için kopyalayın:
- `Components/DataTable.jsx`
- `Components/FormModal.jsx`
- `FormModal.jsx` `prop-types` gerektirir (`npm install prop-types`)

### Rota Kurulumu

Aşağıdaki rotaları `routes/web.php` dosyanıza ekleyin:

```php
Route::resource('posts', \App\Http\Controllers\PostController::class);
Route::get('/posts-react-native', [\App\Http\Controllers\PostController::class, 'reactNative'])->name('posts.react-native');
Route::get('/posts-data', [\App\Http\Controllers\PostController::class, 'ajaxData'])->name('posts.data');
```

Ardından `PostController.php`'ye `reactNative()` metodunu ekleyin (örnek projeye bakın).

### CSRF Token

Bileşenler, mutasyon istekleri için CSRF token'ını `document.querySelector('meta[name="csrf-token"]')` ile alır. Layout dosyanızda (`resources/views/app.blade.php`) bu meta tag'in bulunduğundan emin olun:

```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

> **⚠️ Önemli:** Bazı Inertia starter kit'leri (Breeze React dahil) bu meta tag'i varsayılan olarak İÇERMEZ. fetch istekleriniz 419 (Sayfa Süresi Doldu) hatası döndürüyorsa, önce bu tag'in `<head>` içinde olup olmadığını kontrol edin.

### Global Kütüphane Bağımlılıkları

Vue veya Livewire native bileşenlerinden farklı olarak, React Blade bridge demo sayfası (`Index.jsx`) birkaç global kütüphaneye bağımlıdır:
- **jQuery** ve **DataTables** — orijinal Blade bridge tablo başlatması için
- **Alpine.js** — orijinal Blade bridge modal için
- **SweetAlert2** — silme onayları için
- **dayjs, JSZip, pdfMake** — DataTables dışa aktarma butonları için

Bu kütüphaneler `app.jsx` dosyanızda **Inertia uygulaması oluşturulmadan önce** import edilmeli ve `window` objesine atanmalıdır (örnek projedeki `app.jsx`'e bakın).

> **⚠️ Önemli:** React native bileşenleri (`DataTable.jsx` + `FormModal.jsx` + `IndexReactNative.jsx`) bu global kütüphanelere ihtiyaç duymaz. Sadece native `fetch()` ve React state kullanırlar. Global kütüphaneler yalnızca Blade bridge sayfasını (`Index.jsx`) de çalıştırıyorsanız gereklidir.

### Vite 8 / Rolldown Çözümlemesi

Vite 8+ ve Rolldown kullanıyorsanız (yeni Laravel Breeze React scaffold'larında varsayılan), symlink vendor paketleri (`vendor/gorlabs/tailwind-datatables` path repository ile) `jQuery`, `dayjs` veya `alpinejs` gibi paketleri çözemeyebilir. `Rolldown failed to resolve import "dayjs"` gibi hatalar alırsanız `vite.config.js`'e açık alias'lar ekleyin:

```javascript
import path from 'path';

export default defineConfig({
    // ... diğer config
    resolve: {
        alias: {
            'dayjs': path.resolve(__dirname, 'node_modules/dayjs'),
            'jquery': path.resolve(__dirname, 'node_modules/jquery'),
            'alpinejs': path.resolve(__dirname, 'node_modules/alpinejs'),
            // gerektiğinde diğer paketleri ekleyin
        },
    },
});
```

## Stack Karşılaştırması: Vue vs Livewire vs React

| Özellik | Vue Native | Livewire Native | React Native |
|---------|-----------|-----------------|--------------|
| Framework | Vue 3 (Composition API + TypeScript) | Livewire 3 (PHP + Blade) | React 18 (JSX + Hooks) |
| Veri çekme | `fetch()` + URLSearchParams | Livewire `WithPagination` | `fetch()` + URLSearchParams |
| Form yönetimi | `v-model` + `watch` | Livewire `Form Object` | `useState` + `useEffect` |
| Modal | Native Vue `<Teleport>` | Livewire `wire:model` | `show` prop ile kontrol |
| Validasyon | Alan bazlı hatalar | Livewire `$errors` | Alan bazlı hatalar |
| Sunucu tarafı | Yajra DataTables | Livewire `sortBy()` + paginate | Yajra DataTables |
| Ek bağımlılık | Yok (native fetch) | Yok (Livewire built-in) | `prop-types` |