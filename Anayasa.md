---
name: anayasa
role: Core Engineering & Otonom Standartlar Anayasası
description: SOLID, DRY, LA, Zero-Bypass, Sovereign Data Shield, Multi-Lang UI Standartları ve VCK-v3 Operasyonel Emir Protokolleri
---

# 🏛️ Mimari Anayasa (Architectural Manifesto)

Bu doküman, projedeki kod kalitesini, sürdürülebilirliği, veri güvenliğini ve mühürleme standartlarını belirleyen en üst düzey, değiştirilemez kurallar bütünüdür. Sistemde uyanan tüm personallar bu kurallara kayıtsız şartsız uymakla yükümlüdür.

---\n\n## 1. 🧩 Çekirdek Mühendislik Prensipleri
- **SOLID Prensipleri:** Kod tabanında SRP, OCP, LSP, ISP ve DIP standartları eksiksiz uygulanır. Bir fonksiyon hem DB yazımı yapıp hem UI formatlayamaz.
- **DRY (Don't Repeat Yourself):** Bir mantık sistemde sadece bir kez tanımlanır. Tekrarlanan bloklar Trait, Helper veya Utility sınıflarına çekilir.
- **DI (Dependency Injection):** Sınıflar içinde `new` anahtar kelimesiyle bağımlılık oluşturulamaz; tüm bağımlılıklar Constructor/Setter ile enjekte edilir.
- **LA (Layered Architecture):** Katmanlı mimari sınırları keskindir. Controller/UI sadece isteği alır/döner, Service iş mantığını yürütür, Repository/Data veriye erişir. Katmanlar arası sızıntı (Controller içinde ham SQL vb.) yasaktır.

---\n\n## 2. 🛡️ SOVEREIGN DATA SHIELD & GÜVENLİK YASASI
- **Production Guard:** Üretim ortamına ait hassas dosyalar (Örn: `.env`, sunucu anahtarları, sertifikalar) hiçbir koşulda yerel makinelerden veya otomatik senkronizasyon (rsync vb.) scriptleri tarafından ezilemez, değiştirilemez veya üzerine yazılamaz. Bu dosyalar sunucu tarafında `lsattr` ile mühürlenmek zorundadır.
- **Credential Isolation:** Kod tabanı içinde API anahtarları, şifreler, veritabanı kimlik bilgileri veya gizli jetonlar (tokens) kesinlikle barındırılamaz. Tüm yapılandırma çevre değişkenleri (`.env`) üzerinden yönetilir.
- **SQL & XSS Prevention:** Tüm kullanıcı girdileri katı bir validasyon (doğrulama) ve sanitizasyon (temizleme) işleminden geçmelidir. Ham SQL sorguları (Raw Query) yerine ORM güvenliği veya parametrik sorgular zorunludur.

---\n\n## 3. 🌍 MULTI-LANGUAGE UI & LINGUISTIC STANDARDS
- **Localization Rigidity:** Kullanıcı arayüzünde (UI) görüntülenecek tek bir kelime, cümle veya etiket dahi kod dosyalarının içine (Blade, React, Vue, HTML vb.) ham metin (hardcoded string) olarak yazılamaz.
- **Translation Keys:** Tüm metinsel ifadeler sistemin dil yönetim dosyalarından (Örn: `lang/en.json`, `lang/tr.json` veya i18n modülleri) bir anahtar (key) vasıtasıyla çağrılmalıdır (`__('messages.welcome')` veya `t('welcome')`).

---\n\n## 4. 🕵️‍♂️ ZERO-HARDCODE AUDIT VE OTONOM DENETİM
- **Post-Patch Trigger:** Ajan, herhangi bir dosyada kod yazma veya yama (write/patch) eyleminden hemen sonra otomatik olarak "Zero-Hardcode Audit" moduna geçer. Yazdığı alanı satır satır tarayarak çıplak string veya "sihirli sayı" (magic number) kalmadığını doğrulamadan görevi bitiremez.
- **Audit Kapsamı:** Denetim esnasında linter, static analiz araçları veya regex taramaları kullanılarak tüm yeni kod blokları taranır. Yapılandırma dosyalarına taşınması gereken sabitler anında izole edilir.

---\n\n## 5. 📦 NUMERİK PLANLAMA VE PLAN ISOLATION YASASI
- **Dizin Sınırı:** Tüm planlama, analiz ve yol haritaları SADECE `.agent/plans/` klasörü altında yazılabilir.
- **Ledger ve İş Emri Ayrımı:** `wiki/ledger/a-todo-list.md` dosyası sadece Baş Mimar (Mehmet) tarafından belirlenen ham görevleri ve iş listesini barındırır. Ajan bu dosyayı bir "görev havuzu" olarak okur ancak işi uygulamaya geçirmeden önce tüm teknik tasarımı, Mermaid akış şemalarını ve etki analizlerini SADECE `.agent/plans/` dizini altında yürütür. Bu iki yapı arasında döngüsel geçiş yapılamaz.
- **Numeratör Kuralı (Sequential Increment):** Yeni bir göreve başlamadan önce ajan `.agent/plans/` dizinini tarar. En son dosyanın numarası kaç ise otonom olarak onu bir artırarak (Örn: `0006-[is-adi].md`) yeni planı oluşturur.
- **Plan Şablonu:** Her plan dosyası `## 🎯 Hedef`, `## 🧩 Etkilenecek Dosyalar`, `## 🌍 Çok Dilli Translation Kontrolü` ve `## ⚠️ failed_attempts Risk Analizi` bloklarını içermek zorundadır.
- **Onay Kilidi:** Baş Mimar'dan "Uygula" veya "APPROVED" emri gelene kadar tek bir satır üretim kodu yazılamaz.

---\n\n## 🩻 6. OPERASYONEL EMİR MAKROLARI VE VCK-v3 PROTOKOLÜ
Sistem, `.agent/INDEX.md` dosyasında tanımlanan **VCK-v3 (Yapay Zeka Destekli Profesyonel Geliştirme Protokolü)** kurallarına göre kilitlenmiştir. Ajan, Baş Mimar'dan gelen şu üç makro emre göre hareket etmekle ve 5 Personanın (Bora, Aria, Felix, Deva ve Chronos) bütünsel farkındalığını korumakla yükümlüdür:

- **"X-RAY [Konu]":** Yazma ve kodlama araçları tamamen dondurulur. Ajan sadece derin mantıksal analiz, statik kod taraması ve kök neden tespiti yaparak Baş Mimar'a detaylı bir durum raporu sunar.
- **"HOTFIX [Konu]":** Doğrudan test odaklı (Test-Driven) acil tamir moduna geçilir. Ajan, mevcut planlama adımlarını bypass ederek ilgili bug'ı veya zafiyeti kapatmak için izole bir yama hazırlar ve doğrular.
- **"MÜHÜRLE" / "APPROVED" Emri İşlem Sırası Yasası:** Ajan, Baş Mimar'dan bu emri aldığında aşağıdaki atomik adımları sırasıyla yürütmek zorundadır (Sıra değiştirilemez, adımlar atlanamaz):
    1. **Fiziksel Doğrulama:** Yazılan kodu terminal testleri (linter, unit/integration tests) ve runtime denetimleriyle fiziksel olarak doğrular, kanıtları rapora ekler.
    2. **Approved Ledger Güncellemesi:** Başarıyla tamamlanan ve onaylanan görevi `wiki/ledger/approved.md` sicil dökümanına detayları ve tarihiyle işler.
    3. **Hata ve Risk Kaydı (Lessons Learned):** Eğer geliştirme esnasında teknik bir zorluk, bug veya başarısız bir yaklaşım deneyimlendiyse, bu acı dersi otonom olarak `wiki/ledger/failed_attempts.md` risk kara listesine kaydeder.
    4. **Ready State Durumu:** Görevin kapandığını ilan ederek master context'i günceller ve bir sonraki emir için READY konumuna geçer.
    
    ---\n\n## 7. 🖥️ ORTAM DOKUNULMAZLIĞI (Host/VM Sınırı)
- **Dizin Sınırı:** Ajanlar proje kök dizini dışına (host sistem dosyaları, kardeş projeler, sistem ayarları, diğer kullanıcı dizinleri) kesinlikle müdahale edemez.
- **Kategorik Yasak:** Yıkıcı/geri dönüşsüz komutlar (disk formatlama, rekürsif/toplu silme, sistem seviyesi komutlar, partition işlemleri, `rm -rf` geniş kapsamlı kullanımı) hiçbir gerekçeyle çalıştırılmaz. Bu, Baş Mimar onayı dahi olsa istisnasızdır — ajan böyle bir komutu ÖNERMEZ.
- **Gerekçe:** Bu madde, geçmişte yaşanmış bir tam disk kaybı deneyiminden doğmuştur. `.env` koruması (Madde 2) bu maddenin özel bir alt kümesidir; kapsam artık tüm host/sistem seviyesine genişletilmiştir.

    ---\n\n## 8. 🗑️ TEK-KULLANIMLIK SCRIPT DİSİPLİNİ
- Analiz/keşif/tespit amacıyla yazılan scriptler iş bitince silinir.
- Kalıcı kalması gereken tek şey: (a) onaylanmış implementasyon, (b) ledger'a yazılan bulgu özeti.

    ---\n\n## 9. 🔬 CROSS-VALIDATION VE "KESİN" ETİKETLEME YASASI
- Tek bir gözlem genel kural olarak belgelenemez.
- Bağımsız doğrulama geçmeyen bulgu "KESİN" değil "HİPOTEZ" olarak işaretlenir.

    ---\n\n## 10. 📦 PAKET GELİŞTİRME VE GERİYE DÖNÜK UYUMLULUK (SemVer)
- Breaking değişiklik major versiyon + CHANGELOG.md girdisi olmadan yapılamaz.
- Stack-agnostic hedefli paketlerde belirli bir alt-stack'e örtük bağımlılık adapter katmanı arkasına alınır.
- Public API sebepsiz değiştirilmez; deprecation notice ile önceden duyurulur.

    ---\n\n## 11. ✅ TEST ZORUNLULUĞU
- Yeni özellik en az bir test olmadan tamamlandı sayılamaz.
- Kırılan test MÜHÜRLE onayını otomatik engeller.

    ---\n\n## 12. 🔗 BAĞIMLILIK ZİNCİRİ ANALİZİ
- Silme/imza değişikliği öncesi bağımlı parçalar taranır, etki analizi .agent/plans/'da belgelenir.
- Gereksiz veri toplama/test öncesi mevcut kaynağın tükendiği doğrulanır.

    ---\n\n## 13. 🧱 BASİT/YANLIŞ KOD YASAĞI
- Kırılgan, edge-case gözetmeyen kod hızlı teslim gerekçesiyle dahi onay alamaz.
- Karmaşık mantık okunabilir, adım adım yazılır.

    ---\n\n## 14. 🌐 BU BELGENİN STATÜSÜ
- Bu dosya tüm gorlabs projeleri için TEK global doğruluk kaynağıdır.
- Proje-özel kurallar hedef projeye kopyalandıktan sonra o projenin Anayasa.md'sinin sonuna eklenir, bu merkezi dosya bir daha elle düzenlenmez.
- Global madde ile proje-özel madde çelişirse global madde geçerlidir.

  ---\n\n## 15. 🎯 LARAVEL SÜRÜM DESTEK MATRİSİ (Proje-Özel)

**Kapsam:** Bu madde sadece `tailwind-datatables` paketi için bağlayıcıdır.

- **Desteklenen sürümler:** Laravel 10, 11, 12, **13** — dördü birden, aynı anda.
  Hiçbiri diğeri pahasına bırakılmaz. 13 desteği mevcut 10/11/12 desteğine
  **ek** olarak gelir, onun yerine geçmez (Madde 10 — SemVer, non-breaking).
- **composer.json güncellemesi:** `illuminate/support` kısıtı
  `^10.0 || ^11.0 || ^12.0 || ^13.0` olarak genişletilir. PHP kısıtı
  (`^8.2`) DEĞİŞMEZ — zaten PHP 8.3'ü (Laravel 13'ün minimum şartı)
  kapsıyor.
- **CI Matrix Zorunluluğu (Madde 11'in bu proje için somutlaşması):**
  Test altyapısı TEK bir Laravel versiyonuna karşı çalıştırılamaz.
  GitHub Actions matrix, en az şu 4 kombinasyonu kapsamalı:
  `laravel: [10.*, 11.*, 12.*, 13.*]`. "Testler geçti" raporu, hangi
  versiyon(lar)a karşı çalıştırıldığı belirtilmeden kabul edilmez.
- **Mevcut Sapma Uyarısı:** Bu maddenin yazılma nedeni, ajanın o ana kadar
  yaptığı çalışmayı **sadece Laravel 12 varsayımıyla** yürütmüş olmasıdır.
  Bu, projenin "stack/versiyon-agnostic" temel iddiasına (composer.json'da
  zaten 3 versiyon destekleniyordu) sessizce aykırı bir daralmaydı — X-Ray
  raporunda veya plan 0001'de fark edilmeden geçmişti. Bundan sonraki her
  plan/görev, "hangi Laravel versiyonlarına karşı doğrulandı" sorusuna
  açıkça cevap vermeden MÜHÜRLE onayı alamaz.

---