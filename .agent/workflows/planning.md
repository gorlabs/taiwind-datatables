---
name: planning
description: Detaylı, risk farkındalıklı ve fiziki dosya yollu yol haritası
global_framework: AI_Forge
---

# 📋 Workflow: /plan (Planning)

**Tetikleyici:** `/plan` komutu veya onaylanmış bir brainstorm seansı sonrası.
**Amaç:** Kod yazımına geçmeden önce kesin etki analizi, risk haritası ve Mermaid diyagramı içeren fiziki yol haritası çıkarmak.

---

## Yapısal Kurallar
1. **Fiziki Yollar:** Tüm dosya yolları mutlak veya net proje kök dizinine göre verilecektir (Örn: `app/Http/Controllers/UserController.php`).
2. **Mermaid Zorunluluğu:** En az 1 adet veri akış (Flow) veya bileşen bağımlılık (Dependency) diyagramı çizilecektir.
3. **Rollback Planı:** İşlerin ters gitmesi durumunda veritabanı ve kod seviyesinde geri dönüş adımları yazılacaktır.

## Plan Şablonu
- **Scope (Kapsam):** Doğrudan etkilenecek dosyalar ve katmanlar.
- **Risk Seviyesi & Yan Etkiler:** (Low / Medium / High) - Olası breaking change riskleri.
- **Diyagram:**
  ```mermaid
  [Diyagram İçeriği]
Adım Adım Yol Haritası:

Adım 1: [Fiziki Dosya Yolu] -> Yapılacak net değişiklik (Asla "kodu güncelle" gibi muğlak yazılmaz. Fonksiyon ve satır bazlı hedef belirtilir).

Adım 2: ...

Success Criteria: Teknik başarı doğrulamaları.