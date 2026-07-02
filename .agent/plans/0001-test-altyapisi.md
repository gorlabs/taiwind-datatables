# 0001 - Test Altyapısı Kurulumu (v1.1.0 Önkoşulu)

## 🎯 Hedef
PHPUnit + Orchestra Testbench kurulumu. Mevcut davranışı (Config::set
override dahil, hatalı olanı da) "characterization test" ile kilit altına
al — sonraki hiçbir fix'in davranışı belgesiz/testsiz değişmeyecek.
Bu, sonraki tüm planların (0002+) önkoşuludur; Madde 11 gereği testsiz
hiçbir fix MÜHÜRLE onayı alamaz.

**Laravel Sürüm Desteği (Madde 15):** Laravel 10/11/12/13 — dördü birden.
Test altyapısı tek bir versiyona kilitlenemez. Aşağıdaki versiyon matrisi
bu dört sürümü de kapsar.

## 🧩 Etkilenecek Dosyalar
- `composer.json` → `require-dev` bloğu eklenir (orchestra/testbench,
  phpunit/phpunit — aşağıdaki versiyon matrisine göre seçilir)
- `composer.json` → `require.illuminate/support` kısıtı
  `^10.0 || ^11.0 || ^12.0 || ^13.0` olarak genişletilir (önceden sadece
  ^10||^11||^12 idi — Madde 15 gereği 13 eklendi)
- `phpunit.xml` (yeni)
- `tests/TestCase.php` (yeni, Orchestra Testbench tabanlı)
- `tests/Unit/ServiceProviderTest.php` (yeni) — şunları test eder:
    - View kaydı gerçekleşiyor mu (`tailwind-datatables::datatables.*` resolve oluyor mu)
    - Config publish edilebiliyor mu
    - **`Config::set('datatables-html.*')` override'ının MEVCUT davranışını
      kilitleyen test** (bu, 0002'de opt-in yapılacağında regresyon
      yakalayacak referans nokta)
- `tests/Unit/ConfigTest.php` (yeni) — mevcut config şemasının tüm
  anahtarlarını (`defaults.*`, `views.*`, `assets.*`, `render_options.*`,
  `theme_colors.*`) doğrular

## 🧪 Versiyon Matrisi (Laravel 10/11/12/13 — Doğrulanmış)

| Laravel | Testbench | PHP (CI) | illuminate/support | require-dev constraint |
|---------|-----------|----------|--------------------|------------------------|
| 10.*    | ^8.0      | 8.1+     | ^10.0              | Dinamik (CI'da ayrı)  |
| 11.*    | ^9.0      | 8.2+     | ^11.0              | Dinamik (CI'da ayrı)  |
| 12.*    | ^10.0     | 8.2+     | ^12.0              | Dinamik (CI'da ayrı)  |
| 13.*    | ^11.0     | **8.3+** | ^13.0              | Dinamik (CI'da ayrı)  |

**Önemli notlar (Madde 9 doğrulamasıyla):**
- Testbench ^10 sadece Laravel 12'yi destekler. Laravel 13'ü desteklemez.
- Testbench ^11 Laravel 13'ü destekler ve **PHP ^8.3 zorunluluğu** getirir.
- Dört Testbench major'ü (`^8`, `^9`, `^10`, `^11`) tek bir `composer.json`
  require-dev constraint'inde birleştirilemez — conflict eder.
- **Çözüm:** CI'da her leg kendi `composer require --dev` komutunu
  çalıştırır. Lokal geliştirmede sadece mevcut ortamın kombinasyonu
  kurulur.

## 🔧 Mevcut Kurulum Durumu (Fiziksel Doğrulama)

**Sadece TEK kombinasyon test edildi — 3 versiyon henüz doğrulanmadı:**

| Bileşen     | Değer                              |
|-------------|------------------------------------|
| Laravel     | 12.* (illuminate/support v12.62.0) |
| Testbench   | ^10.0 (v10.11.0)                   |
| PHP         | 8.3.31                             |
| PHPUnit     | 11.5.55                            |
| Test Sonucu | **22/22 OK, 47 assertions**        |

**Henüz test edilmeyen kombinasyonlar:**
- ❌ Laravel 10 + Testbench ^8 + PHP 8.1+
- ❌ Laravel 11 + Testbench ^9 + PHP 8.2+
- ❌ Laravel 13 + Testbench ^11 + PHP 8.3+

Bu kombinasyonlar ancak GitHub Actions CI matrix'i (0002+ planında
eklenecek) ile doğrulanabilir. Mevcut test kodunun bu versiyonlarda da
çalışması beklenir çünkü Orchestra Testbench ve PHPUnit API'leri geriye
dönük uyumludur, ancak bu bir **hipotezdir (Madde 9)** — doğrulanana
kadar "KESİN" değildir.

## 💡 CI Matrix Taslağı (0002+ Eklenecek)

```
# .github/workflows/tests.yml (taslak, 0002 planında oluşturulacak)
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
      - run: composer require --dev "orchestra/testbed:${{ matrix.testbench }}" --no-update
      - run: composer update --prefer-dist --no-progress
      - run: vendor/bin/phpunit
```

## 🌍 Çok Dilli Translation Kontrolü
Bu faz test altyapısı kurulumu olduğu için doğrudan çeviri/lokalizasyon
etkisi yok. Ancak `ConfigTest.php`, `render_options` içindeki Türkçe
hard-coded değerlerin (date_format, status_badges) MEVCUT halini de
characterization test olarak kaydeder — 0003'te bunlar config-driven
yapıldığında referans/regresyon noktası olacak.

## ⚠️ failed_attempts Risk Analizi

### Hata #001: Testbench ^10'un Laravel 13'ü kapsadığı hipotezi (KAPANDI)
**İlk versiyonda**, Chronos (ajan) `orchestra/testbench ^10` ile
Laravel 12 ve 13'ün her ikisinin de desteklendiğini varsaydı. Bu
doğrulanmamış bir varsayımdı (training data bias'ı).

**Doğrulama:** `composer show orchestra/testbench --all` ve Packagist
üzerinden yapıldı. Testbench ^10'un `illuminate/support ^12.0` gerektirdiği,
yani **sadece Laravel 12** için olduğu tespit edildi. Laravel 13 için
Testbench ^11 gerekli.

**Zincirleme etki:** Testbench ^11, PHP ^8.3 zorunluluğu getiriyor.
composer.json'daki `"php": "^8.2"` runtime için kalabilir, ancak CI'da
Laravel 13 leg'i PHP 8.3+ kullanmazsa Testbench ^11 hiç kurulamaz.

**Düzeltme:** CI matrix taslağı ayrı PHP versiyonlarıyla güncellendi.
require-dev'de tüm Testbench major'leri birleştirmek yerine her CI leg'i
kendi testbench'ini kurar.

### Bilinen Riskler
- CI matrix henüz yok (0002+ planında eklenecek). O ana kadar 4
  versiyondan sadece 1'i doğrulanmış durumda.
- Gerçek kullanıcı riski: SIFIR — bu faz sadece dev-dependency ekliyor,
  publish edilen pakette hiçbir çalışma zamanı değişikliği yok.

## Onay Kilidi
Baş Mimar'dan "MÜHÜRLE" veya "APPROVED" emri gelmeden tek satır kod
yazılmaz (Madde 5). Test dosyaları yazıldı, terminal çıktısı alındı;
onay sonrası `wiki/ledger/approved.md` güncellenecek.