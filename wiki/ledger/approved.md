# 📜 approved.md — The Sealed Ledger (Mühürlü Kararlar)

*Bu dosyadaki kararlar ve kod yapıları Baş Mimar tarafından onaylanmıştır. AI ajanları için değiştirilemez, silinemez ve üzerine yazılamaz mutlak yasadır.*

---

## 🏛️ AJANLAR İÇİN MÜHÜRLEME YASASI
1. **Salt Okunur Geçmiş:** Geçmiş tarihlerde eklenmiş ve onaylanmış hiçbir satır üzerinde modifikasyon yapılamaz, silinemez.
2. **Yeni Kayıt Ekleme:** Sadece Baş Mimar **"Mühürle"** veya **"Onaylıyorum"** emrini verdiğinde, en son tamamlanan ve testleri başarıyla geçen task buraya yeni bir satır olarak eklenir.
3. **Mühür Sadakati:** `User Seal` sütununa Baş Mimar'ın mutlak imza kodu olan `MEHMET_CETIN_RAVULLU` aynen işlenmek zorundadır.

---

## ✅ Approved Decisions (Onaylanmış Kararlar)

| Tarih | Bileşen / Modül | Alınan Karar & Çözülen Kusursuz Yapı | User Seal (Mühür) |
| :--- | :--- | :--- | :--- |
| 2026-06-02 | System | Initial Forge setup completed. Global anayasa ve otonom kurulum kalıpları devreye alındı. | MEHMET_CETIN_RAVULLU |
| 2026-07-02 | Plan 0001 — Test Altyapısı | PHPUnit + Orchestra Testbench kurulumu. 22 test (47 assertion) ile ServiceProvider davranışı (Config::set override dahil) characterization test ile kilit altına alındı. Madde 15 versiyon matrisi belgelendi (Laravel 10/11/12/13; henüz sadece Laravel 12 + Testbench ^10 + PHP 8.3 kombinasyonu fiziksel test edildi; 10/11/13 hipotez). | MEHMET_CETIN_RAVULLU |
| 2026-07-02 | Plan 0002 — Yajra Config Opt-In + Alpine Düzelt + CI Matrix | Config::set override opt-in yapıldı (override_yajra_config, varsayılan true). post-form.js'teki çift Alpine.data kaydı kaldırıldı (tek kayıt crud-datatable.js). CI matrix workflow oluşturuldu (Laravel 10/11/12/13). 25 test (54 assertion) geçti — sadece L12 kombinasyonu fiziksel test edildi; L10/L11/L13 CI'da doğrulanmayı bekliyor. | MEHMET_CETIN_RAVULLU |
