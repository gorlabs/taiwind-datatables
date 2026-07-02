# Livewire 3 Native Bileşenleri (Plan 0005)

Bu doküman, Plan 0005 kapsamında Blade bridge yaklaşımına alternatif olarak eklenen Livewire 3 native bileşenlerini açıklar.

> **Not:** Blade bridge (form.blade.php'nin Alpine.js ile kullanıldığı orijinal yaklaşım) hâlâ tam desteklenmektedir ve değişmemiştir. Yeni Livewire native bileşenler eklentiseldir ve isteğe bağlıdır.

## Genel Bakış

Paket şu anda `examples/livewire/` demo projesinde bir Livewire 3 bileşeni içermektedir:

### PostsTable (Full-Stack Livewire Bileşeni)

Livewire 3 ile oluşturulmuş eksiksiz bir CRUD bileşeni:

- Flux sidebar bağımlılığı olmadan render etmek için `#[Layout('layouts.posts-demo')]` kullanır
- **Sunucu taraflı sıralama** destekler (sütun başlıklarına tıklayarak artan/azalan sıralama)
- **Sunucu taraflı arama** destekler (300ms debounce ile `wire:model.live.debounce.300ms`)
- `Livewire\WithPagination` trait'i ile **sunucu taraflı sayfalama** (sayfa başına 10 kayıt)
- Create, Edit ve Delete işlemleriyle **tam CRUD arayüzü**
- Doğrulama ve veri yönetimi için **Livewire Form Object** (`PostForm`) kullanır
- Durum rozetleri gösterir (Published: yeşil / Draft: sarı)
- Vue native bileşenleriyle görsel pariteyi yakalar

### PostForm (Livewire Form Object)

`app/Livewire/Forms/PostForm.php` konumunda bulunan bu form nesnesi:

- `title`, `content`, `is_published` ve `published_at` alanlarını kapsüller
- PHP 8 attribute tabanlı doğrulama kullanır (`#[Validate]`)
- `store()` ve `update()` metotlarını sağlar
- Düzenleme için formu dolduran `setPost()` metodunu içerir

## Demo Sayfası

`/posts-livewire-native` rotası doğrudan `PostsTable` component'ini render eder:

```php
Route::get('/posts-livewire-native', \App\Livewire\PostsTable::class)
    ->middleware('auth')
    ->name('posts.livewire-native');
```

## Blade Bridge'e Göre Avantajlar

| Özellik | Blade Bridge (Orijinal) | Livewire Native (Yeni) |
|---------|------------------------|----------------------|
| Form yönetimi | Alpine.js + fetch() | Livewire Form Object |
| Reactivity | Alpine.js x-model | Livewire wire:model |
| Modal | SweetAlert2 / özel JS | Livewire koşullu render |
| Sayfalama | Yajra DataTables JS | Livewire WithPagination trait |
| Arama | Yajra DataTables API | Livewire wire:model.live |
| Sıralama | Yajra DataTables API | Livewire wire:click + query |

## Kurulum

Bileşen dosyaları şu konumda bulunur:

```
examples/livewire/
├── app/Livewire/PostsTable.php
├── app/Livewire/Forms/PostForm.php
├── resources/views/livewire/posts-table.blade.php
└── resources/views/layouts/posts-demo.blade.php
```

### Adım 1: Bileşen dosyalarını kopyalayın

Aşağıdaki dosyaları Livewire destekli Laravel projenize kopyalayın:

- `app/Livewire/PostsTable.php` → `app/Livewire/PostsTable.php`
- `app/Livewire/Forms/PostForm.php` → `app/Livewire/Forms/PostForm.php`
- `resources/views/livewire/posts-table.blade.php` → `resources/views/livewire/posts-table.blade.php`

### Adım 2: Layout oluşturun (isteğe bağlı)

Varsayılan Flux sidebar layout'undan kaçınmak için `resources/views/layouts/posts-demo.blade.php` dosyasını projenizin `resources/views/layouts/` dizinine kopyalayın ve `#[Layout]` attribute'unda referans verin.

Eğer `#[Layout]` attribute'unu kaldırırsanız, Livewire `config/livewire.php` dosyasında tanımlı varsayılan layout'u kullanır (genelde `layouts.app`).

### Adım 3: Route'u ekleyin

```php
Route::get('/posts-livewire-native', \App\Livewire\PostsTable::class)
    ->middleware('auth')
    ->name('posts.livewire-native');
```

### Adım 4: Post modelinin varlığını kontrol edin

Bileşen `App\Models\Post` modelini kullanır. Projenizde aşağıdaki alanlara sahip bir `Post` modeli olduğundan emin olun:
- `id` (integer, auto-increment)
- `title` (string, 255)
- `content` (text)
- `is_published` (boolean)
- `published_at` (datetime, nullable)

### Adım 5: Özelleştirme

Bileşeni aşağıdaki şekillerde özelleştirebilirsiniz:

- `paginate()` çağrısındaki `$perPage` değerini değiştirerek
- `sortField` ve `sortDirection` varsayılanlarını değiştirerek
- `render()` metodundaki search sorgusuna sütunlar ekleyerek
- Blade template'indeki modal ve tablo class'larını stillendirerek