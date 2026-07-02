# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2026-07-02

### Added
- `override_yajra_config` config anahtarı (varsayılan: true). false yapılırsa
  `Config::set('datatables-html.*')` runtime override'ı devre dışı kalır.
- `.github/workflows/tests.yml` — CI matrix (Laravel 10/11/12/13, PHP 8.1/8.2/8.3).
- `window.GorlabsDatatables.config` JS bridge — config değerlerini PHP'den JS'e aktarır.
- `resources/lang/tr.json` ve `resources/lang/en.json` — Blade form metinleri çeviri anahtarları.
- Vue 3 native bileşenleri (examples/vue): `DataTable.vue`, `FormModal.vue`, `IndexVueNative.vue`.
- `/posts-vue-native` rotası (Vue-native demo sayfası).
- `docs/en/vue-native-components.md` ve `docs/tr/vue-native-bilesenler.md`.

### Changed
- `resources/js/post-form.js`: `Alpine.data('postForm', ...)` kaydı kaldırıldı.
  Kayıt artık sadece `crud-datatable.js` üzerinden yapılır.
- `src/TailwindDatatablesServiceProvider.php`: `Config::set('datatables-html.*')`
  override'ı `override_yajra_config` kontrolüne alındı.
- `resources/views/datatables/form.blade.php`: 7 hardcoded Türkçe metin lang dosyalarına taşındı.
- `resources/views/datatables/scripts.blade.php`: JS-CONFIG BRIDGE eklendi.
- `resources/js/crud-datatable.js`: `statusBadge()` config-driven oldu (fallback Türkçe korunur).
- `resources/js/post-form.js`: SweetAlert mesajları config-driven oldu (fallback Türkçe korunur).
- `README.md`: docs/tr/README.md ayrıldı, karşılıklı dil linkleri eklendi.

## [1.0.0] - 2024-07-08

### Added
- Initial release of Gorlabs Laravel Tailwind DataTables package.
- Seamless integration of Yajra DataTables with Tailwind CSS and Alpine.js.
- Customizable views, config, and assets.
- Automatic Yajra DataTables HTML configuration (`script` and `view` paths).
- Rich column customization options (date formatting, status badges, text truncation).
- Comprehensive `README.md` with setup guides for Livewire and Vue.js stacks.
- MIT License.
- Initial `CHANGELOG.md` for version tracking.
- Global Alpine.js components and SweetAlert2 integration for CRUD operations.

### Changed
- N/A (İlk sürüm olduğu için değişiklik yok)

### Fixed
- N/A (İlk sürüm olduğu için düzeltme yok)

### Removed
- N/A (İlk sürüm olduğu için kaldırılan bir şey yok)
