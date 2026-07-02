# 📖 MCP: Context7 (Dokümantasyon Senkronizasyonu)
name: context7
description: Bilgi tabanı, teknik dökümanlar, API dokümantasyonu ve değişim günlüklerinin (Changelog) senkronizasyonu

---

## 🎯 Ne Zaman Çağrılır?
- ✅ Planlama aşamasında dökümantasyon gereksinimleri belirlenirken[cite: 20, 21].
- ✅ Kod geliştirme tamamlandıktan hemen sonra (Eş zamanlı dökümantasyon kuralı)[cite: 21].
- ✅ Sürüm geçişlerinde ve mimari güncellemelerde kalıcı hafızayı tazelemek için[cite: 21].

---

## 💬 Çağrı Protokolü

"Context7 MCP'sini kullanarak sistem dökümantasyonunu en güncel kod durumuna göre senkronize et:  Güncellenecek Hedefler:  README.md / INDEX.md: [Yeni eklenen mimari katmanlar veya kurulum adımları]  API / Kontrat Dökümantasyonu: [Yeni endpointler, veri şemaları veya arayüz kontratları]  CHANGELOG.md: [Sürüm numarası ve yapılan ekleme/düzeltme listesi]  Beklenen: Zaman damgalı, doğrulanmış ve kodla birebir eşleşen güncel dökümantasyon seti."[cite: 20]