# Vue 3 Native Bileşenleri (Plan 0004)

Bu doküman, Plan 0004 kapsamında Blade bridge yaklaşımına alternatif olarak eklenen Vue 3 native bileşenlerini açıklar.

> **Not:** Blade bridge (form.blade.php'nin fetch edilip Vue modal içine enjekte edildiği orijinal yaklaşım) hâlâ tam desteklenmektedir ve değişmemiştir. Yeni Vue native bileşenler eklentiseldir ve isteğe bağlıdır.

## Genel Bakış

Paket şu anda `examples/vue/` demo projesinde iki Vue 3 Single File Component (SFC) içermektedir:

### DataTable.vue
Sunucu taraflı sayfalama yapan veri tablosu bileşeni:
- Mevcut `/posts-data` AJAX endpoint'ine bağlanır (aynı Yajra DataTables endpoint'i)
- Sunucu taraflı sayfalama, arama ve sütun sıralama destekler
- CRUD işlemleri için `edit` ve `delete` event'leri yayar
- Native `fetch()` API kullanır (ek bağımlılık gerekmez)

### FormModal.vue
Modal form bileşeni:
- Hem Create hem Edit işlemlerini yönetir
- Mevcut `/posts` RESTful endpoint'lerine bağlanır (POST create, PUT update)
- Açılıp kapanırken form state'ini sıfırlar
- `saved` ve `close` event'leri yayar

## Demo Sayfası

`/posts-vue-native` rotası, her iki bileşeni birleştiren `IndexVueNative.vue` sayfasını render eder.

## Blade Bridge'e Göre Avantajlar

| Özellik | Blade Bridge (Orijinal) | Vue Native (Yeni) |
|---------|------------------------|-------------------|
| Form render | Blade view fetch → innerHTML | Native Vue template |
| Reactivity | Alpine.js x-model | Vue v-model |
| Modal | Alpine globalModal | Native Vue bileşeni |
| Bundle | Alpine.initTree gerekli | Ek başlatma gerekmez |