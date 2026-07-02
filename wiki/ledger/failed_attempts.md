# ⚠️ failed_attempts.md — Başarısız Denemeler ve Alınan Dersler

*Bu dosya, proje geçmişinde denenen ama başarısız olan, yan etki yaratan veya Baş Mimar tarafından reddedilen operasyonların otonom günlüğüdür. Ajanlar aynı tuzaklara tekrar düşmemek için bu dosyayı her task başında incelemekle yükümlüdür.*

---

## 🚫 Başarısız Girişimler ve Çıkarılan Dersler

| Tarih | Hedef / Ne Çözülmeye Çalışıldı? | Uygulanan Yöntem / Kod | Patlama Nedeni & Alınan Acı Ders | Geri Alındı mı? |
| :--- | :--- | :--- | :--- | :--- |
| 2026-05-27 | deployment-watch.sh ile server senkronizasyonu | rsync komutunun çıplak ve guardsız çalıştırılması | `.env` dosyası ezildi, hassas ayarlar kayboldu ve site crash oldu. **DERS:** Production `.env` dosyası asla otomatik ezilemez, manuel yönetilir. rsync'e exclude kuralı eklendi. | EVET (2 saatte kurtarıldı) |
| 2026-07-02 | Plan 0001 — Testbench ^10 Laravel 13'ü kapsar hipotezi | Testbench ^10 constraint'inin "Laravel 12 & 13" diye varsayılması, composer.json require-dev'de ^8\|\|^9\|\|^10 olarak yazılması (^11 atlanması) | **Doğrulandı:** Testbench ^10 sadece Laravel 12'yi destekler (illuminate/support ^12.0 zorunluluğu). Laravel 13 için Testbench ^11 gerekli (PHP 8.3+). **DERS:** Madde 9 (Cross-Validation) atlanmıştı. Training data bias'ı ile varsayım yapıldı, Packagist/composer show ile doğrulanmalıydı. Düzeltildi: CI matrix 4 ayrı PHP+Testbench kombinasyonuyla güncellendi. | HAYIR (hiç çalışmadı, plan revize edildi) |
| 2026-07-02 | Plan 0002 — AlpineRegistrationTest regex hatası | `AlpineRegistrationTest`'te `Alpine\.data('postForm',` pattern'i kullanıldı, crud-datatable.js `AlpineInstance.data('postForm', postForm)` çağrısını yakalamadı | Regex `\w+\.data('postForm',` olarak genelleştirildi. **DERS:** Statik taramada pattern'in tüm değişken adlarını kapsadığı doğrulanmalı. Manuel grep ile kontrol edildi (AlpineInstance.data satır 108). Test revize edildi, 25/25 OK. | HAYIR (test revize edildi) |