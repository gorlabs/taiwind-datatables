---
name: coding
description: Test-Driven Execution (TDE) Protokolü
global_framework: AI_Forge
---

# 🛠️ Workflow: /code (Coding - Test-Driven Execution)

**Tetikleyici:** `/code` komutu (Architecture Review onayı sonrası).
**Amaç:** VCK-v3 TDE protokolünü işleterek hatasız, test edilmiş ve kurallara tam uyumlu kod üretmek.

---

## Mühürlü Kodlama Kuralları
1. **Boyut Sınırı:** Hiçbir fonksiyon **30 satırı**, hiçbir fiziksel dosya **200 satırı** geçemez!
2. **Inline Yorum Yasaktır:** Kod kendi kendini açıklayacak kadar temiz olmalı, sadece metot başlarında PHPDoc/JSDoc formatında blok dökümantasyon olabilir. Kod içinde satır arası `// bu işlem şunu yapar` yazılmaz.
3. **Magic Numbers:** Kod içinde ham sayılar veya string konfigürasyonlar (Örn: `3600`, `auth_secret`) kullanılamaz. Hepsi Laravel `config/` veya React sabitlerine taşınmalıdır.

## 4 Evre TDE Döngüsü

### 🔴 EVRE 1: RED (Test/Başarı Kriteri Tanımı)
Kod yazılmadan önce başarısız olacak test senaryosu veya manuel kontrol adımı yazılır/çalıştırılır. Başarısızlık fiziksel olarak görülür.

### 🟢 EVRE 2: GREEN (Minimum Kod ile Çalıştırma)
Testi veya kontrolü başarılı kılacak en yalın kod ilgili fiziki dosyalara yazılır. Test/Kontrol çalıştırılarak `PASSED` durumu yakalanır.

### 🔵 EVRE 3: REFACTOR (Temizleme)
Yazılan yeşil kod, boyut sınırlarına (30 satır fonksiyon / 200 satır dosya) ve temiz kod prensiplerine göre optimize edilir. Testlerin hala başarılı olduğu doğrulanır.

### 🟣 EVRE 4: QUALITY (Son Kontrol)
Linter, formatlayıcılar çalıştırılır. Memory sızıntısı veya yan etki analizi doğrulanır.