# 🎨 MCP: Chrome DevTools (Performans ve Render Doğrulama)
name: chrome-devtools
description: Önyüz (Frontend) performans metriklerini, bellek sızıntılarını ve Web Vitals değerlerini ölçümleme aracı

---

## 🎯 Ne Zaman Çağrılır?
- ✅ Kalite kontrol (QA) ve optimizasyon aşamalarında[cite: 18, 21].
- ✅ Arayüz bileşenlerinin render sürelerini ve bellek (memory heap) durumlarını incelerken.

---

## 💬 Çağrı Protokolü

"Chrome DevTools MCP'sini kullanarak hedeflenen arayüzün performans ve Web Vitals metriklerini raporla:  Hedef URL/Bileşen: [Test ortamı adresi]
Ölçüm Kriterleri:  Web Vitals: LCP, FID, CLS değerleri  Bellek Durumu: Etkileşim öncesi ve sonrası Heap Used karşılaştırması  Ağ / Kaynak: JS/CSS paket boyutları (Bundle Size impact)[cite: 18]Beklenen: Üretime hazır (Ready for Production) durumunu onaylayan veya optimizasyon öneren teknik rapor."[cite: 18]