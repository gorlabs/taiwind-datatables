# 🏛️ PROJE MİMARİ ÖZETİ: GLOBAL MASTER TEMPLATE

## 🛡️ MİSYON: MİMARİ BÜTÜNLÜK VE KOD EGEMENLİĞİ
Bu döküman, sistemin uzun ömürlü, sürdürülebilir ve hatasız kalması için gereken yapısal zekayı ve mimari sınırları özetler. Projeye dahil olan her ajan (AI), bu kuralların dışına çıkamaz ve kod tabanını bu katmanlara sadık kalarak geliştirmek zorundadır.

---

## 🏗️ 1. ÇEKİRDEK MİMARİ KATMANLARI
Sistem, sorumlulukların net olarak ayrılması (Separation of Concerns) ve SOLID prensipleri uyarınca katmanlı bir yapıya sahiptir:

1. **Çekirdek/İş Mantığı Katmanı (Business Logic & Core):** Tüm ana kuralların, veri modellerinin ve sistem lojistiğinin yönetildiği merkez. Sunum veya arayüz katmanından tamamen bağımsız çalışmalıdır.
2. **Köprü/Veri Taşıma Katmanı (Bridge / API / Transport):** Verinin katmanlar veya istemci-sunucu arasında güvenli, performanslı ve doğrulanmış (validated) olarak taşınmasını sağlayan kurye mekanizması.
3. **Sunum/Arayüz Katmanı (Presentation / UI):** Kullanıcı etkileşimlerinin yönetildiği, tasarım sistemine sıkı sıkıya bağlı ve kendi içinde ağır iş mantığı barındırmayan reaktif katman.

---

## 🛡️ 2. YÖNETİŞİM VE GÜVENLİK SINIRLARI
Projede temiz kod ve güvenlik bir anayasadır. Hiçbir bileşen bu sınırları delemez:

* **Modüler Egemenlik (Modular Sovereignty):** Her özellik veya servis kendi egemenlik alanına sahiptir. Bir modül, diğer bir modülün dahili koduna veya alanına doğrudan müdahale edemez. İletişim soyut katmanlar (Interfaces/Contracts/APIs) üzerinden yürütülür.
* **Gizli Bilgi Yönetimi (Zero-Hardcode):** Kod dosyaları içerisine gömülmüş (hardcoded) API anahtarları, veritabanı şifreleri, IP adresleri veya hassas meta veriler kesinlikle yasaktır. Tüm dinamik ayarlar ortam dosyalarından (`.env` veya Kasa/Vault sistemlerinden) beslenmelidir.
* **Yetkilendirme ve İzolasyon:** Kullanıcı ve sistem yetkileri kod seviyesinde geçici `if/else` bloklarıyla bypass edilemez. Yetkilendirme her zaman merkezi bir kontrol matrisi üzerinden doğrulanmalıdır.

---

## 🌐 3. EVRENSEL DİL VE ULUSLARARASILAŞTIRMA (i18n)
Küresel operasyonlara uygun altyapı:
* **Safe-Keys:** Kod içinde ham metin (hardcoded string) kullanımı yasaktır. Tüm metinler, projenin dil/çeviri motoru üzerinden dinamik anahtarlar vasıtasıyla çağrılmalıdır.

---

## 🛠️ GELİŞTİRME VE AJAN PROTOKOLLERİ (ARCH-DEV)

### 1. Ajan-Geçirmez Kodlama (Agent-Proof Coding)
Yapay zekanın halüsinasyon görmesini, kodun şişmesini ve okunabilirliğin kaybolmasını engellemek amacıyla:
* Hiçbir fonksiyon/metot **30 satırı** geçemez.
* Hiçbir kaynak kod dosyası (veri modelleri ve büyük arayüz bileşenleri hariç) **200 satırı** geçemez.

### 2. Test Güdümlü Geçit (TDD Gateway)
İlgili davranışı veya hatayı doğrulayan bir başarısız test (RED Phase) yazılmadan tek bir satır üretim kodu yazılamaz veya değiştirilemez. Test paketi projenin yargı erkidir.

---

## 📜 FİNAL MÜHÜR
Projenin mimari bütünlüğü sarsılmaz, kod kalitesi en üst düzeydedir. Ajan, bu şablona göre projenin güncel durumunu analiz etmek ve sınırları korumakla yükümlüdür.