# 🔐 SARSILMAZ KURAL: [KURALIN / STANDARTIN ADI]

## 🎯 1. KURAL TANIMI VE ANATOMİSİ
Proje genelinde [Sorunun Yaşandığı Alan - Örn: Yetkilendirme, API Şeması, Durum Yönetimi] süreçlerinde standardizasyonu korumak amacıyla bu kural kesin bir yasa olarak mühürlenmiştir:

* **Zorunlu Standart:** [Uygulanması gereken format veya yapı - Örn: {domain}:{verb}:{target} veya camelCase naming]
* **Temel Gerekçe:** [Bu kuralın neden var olduğu, mimari açıdan neyi koruduğu]

## 🚫 2. MUTLAK YASAKLAR VE ANTİ-PATTERN'LAR
Sistemde build veya çalışma zamanı (runtime) hatalarına yol açan, tolerans gösterilmeyecek hatalı kullanımlar:
* ❌ [Hatalı Kullanım Örneği 1 - Örn: Tireli (hyphen) yetki anahtarı kullanımı]
* ❌ [Hatalı Kullanım Örneği 2 - Örn: Controller içinde ham SQL sorgusu yazılması]

## 🔍 3. FİZİKSEL KANIT VE CERRAHİ MÜDAHALE LOGU
Bu kuralın tetiklenmesine neden olan somut vaka analizi (Post-Mortem):
* **Tespit Edilen İhlal:** [Hatanın tam tanımı ve sistemde yarattığı yan etki]
* **Uygulanan Düzeltme:** [Kaç dosyada, hangi yöntemle cerrahi müdahale yapıldığı]
* **Mevcut Durum Metriği:** Dosya taramaları ve statik analizörler ile yapının temizlendiği fiziksel olarak doğrulanmıştır (Örn: DB'de X adet kurala uygun kayıt, frontend'de Y adet temiz referans).

## 🧪 4. TEST BOŞLUĞU VE ÖNLEME PROTOKOLÜ (REGRESSION GUARD)
Bu hatanın gelecekteki ajansal işlemler veya insan müdahaleleriyle tekrar sisteme sızmasını ENGELLEMEK için tasarlanan otomatik koruma bariyeri (Test Pattern):

```[target_language]
// ÖRNEK KORUYUCU TEST KALIBI (Framework bağımsız jenerik örnek)
// Test, kurala uyan yapıyı doğrularken hatalı formatın sızıp sızmadığını kontrol etmelidir.
test('should enforce structural integrity and reject invalid anti-patterns', function () {
    // 1. Arrange (Hazırlık)
    // 2. Act (Eylem)
    // 3. Assert (Doğrulama / Hatalı yapının missing olduğunu kanıtlama)
});
🔗 5. BAĞLAMSAL REFERANSLAR VE MÜHÜRLER
Bu kural güncellemesinin kalıcı hafızadaki yerleşim koordinatları:

Ana Bilgi Kaydı: .agent/knowledge/INDEX.md (İlgili sürüm veya güncelleme kodu ile)

Mühürlü Karar Defteri: wiki/ledger/approved.md (Zaman damgası ve Baş Mimar Mührü ile)