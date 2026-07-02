---
name: final-review
description: Üretim öncesi son hijyen, güvenlik ve performans kapısı
global_framework: AI_Forge
---

# 🎯 Workflow: /review (Final Review)

**Tetikleyici:** Coding workflow başarıyla tamamlandığında otomatik.
**Amaç:** Kodu ana branch'e birleştirmeden veya canlı sunucuya sync etmeden önce production-ready olduğunu nesnel kriterlerle doğrulamak.

---

## 5 Kritik Kontrol Başlığı

### 1. Kod Hijyeni (VCK Standards)
- Fonksiyon/dosya satır sınırları aşılmamış. Inline yorum yok. Unused import/variable kalmamış. `dd()`, `dump()`, `console.log()` temizlenmiş.

### 2. Güvenlik Denetimi
- Laravel validation kuralları eksiksiz. Yetkilendirme (Policy/Middleware) aktif. Mass assignment koruması (`$fillable`/`$casted`) yerinde.

### 3. Performans & DB Denetimi
- Eloquent lazy loading engellenmiş, N+1 sorgu problemi yok. Performans metrikleri kabul edilebilir sınırlarda.

### 4. Dökümantasyon & Tip Kontrolü
- Değişen fonksiyonların PHPDoc/TypeScript tipleri eksiksiz güncellenmiş.

### 5. Deployment / Env Guard Check
- Canlı sunucu `.env` bütünlüğünü bozacak veya rsync ezilmesine sebep olacak bir dizin manipülasyonu yok.

## Karar Kapısı
- **ALL PASS** ➡️ Merge/Deploy approved 🚀
- **CRITICAL FAIL** ➡️ Block merge! Fix required.