# Temel Kullanım ve Yapılandırma

## Kurulum

```bash
composer require gorlabs/tailwind-datatables
```

## Yapılandırma

Paketin varsayılan ayarlarını değiştirmek için konfigürasyon dosyasını yayımlayın:

```bash
php artisan vendor:publish --tag=gorlabs-tailwind-datatables-config
```

Bu komut, `config/gorlabs-tailwind-datatables.php` dosyasını projenize kopyalar.

### Kullanılabilir Yapılandırma Seçenekleri

#### `override_yajra_config` (boolean, varsayılan: `true`)

Paketin Yajra DataTables HTML yapılandırmasını çalışma zamanında geçersiz kılıp kılmayacağını kontrol eder.

- **`true`** (varsayılan): Paket otomatik olarak `datatables-html.script` ve `datatables-html.view` değerlerini kendi Blade view'larını kullanacak şekilde ayarlar. Yeni projeler için önerilen ayardır.
- **`false`**: Paket Yajra'nın yapılandırmasını geçersiz kılmaz. Kendi değerlerinizi `config/datatables-html.php` dosyasında ayarlayabilirsiniz.

> **Uyarı:** `false` olarak ayarlandığında, ilgili `config/datatables-html.php` anahtarlarını manuel olarak yapılandırmadığınız sürece Blade view'ları beklendiği gibi görünmeyebilir.

#### Diğer Seçenekler

Yayımlanan `config/gorlabs-tailwind-datatables.php` dosyasında `defaults`, `views`, `assets`, `render_options` ve `theme_colors` dahil tüm kullanılabilir seçeneklerin tam dokümantasyonunu bulabilirsiniz.