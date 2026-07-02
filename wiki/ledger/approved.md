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
| 2026-07-02 | Plan 0002 — CI Matrix Doğrulama (Tamamlama) | GitHub Actions'ta feature/v1.1.0-test-infra-ci branch'i, commit aa50e05, run #5: 4/4 leg yeşil (L10 PHP8.2+TB^8.0 16s, L11 PHP8.2+TB^9.0 20s, L12 PHP8.2+TB^10.0 17s, L13 PHP8.3+TB^11.0 17s, toplam 25s). composer.json'a yajra/laravel-datatables-{oracle,buttons,html} kısıtlarına ^13.0 eklendi (Madde 12). Composer 2.9 audit-block, config.policy.advisories.block=false ile root-context'e özel devre dışı bırakıldı (downstream tüketicileri etkilemez). L10 leg'i PHP 8.1 → 8.2 olarak matrix'te düzeltildi (composer.json'daki php ^8.2 kısıtıyla uyum). | MEHMET_CETIN_RAVULLU |