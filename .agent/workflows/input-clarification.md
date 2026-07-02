---
name: input-clarification
description: Muğlak girdileri netleştirme - 4 Stratejik Soru
global_framework: AI_Forge
---

# 🔍 Workflow: /clarify (Input Clarification)

**Tetikleyici:** Muğlak, kısa, teknik detay içermeyen girdi algılandığında otomatik veya manuel `/clarify`.
**Amaç:** Prompt'u körü körüne işlemeyip, mimari zafiyetleri engellemek için 4 stratejik soru ile güçlendirmek.

---

## Muğlak Input Kriterleri
- "Şunu ekle", "Bunu optimize et", "Hata veriyor çöz" gibi 1-2 satırlık girdiler.
- Teknik kapsamı, veritabanı veya state etkileri belirtilmemiş istekler.

## Soru Matrisi (4 Stratejik Soru)
1. **Q1 (Asıl Hedef):** Bu görevin sonunda tam olarak elde etmek istediğiniz işlevsel çıktı nedir?
2. **Q2 (Kapsam & Bileşenler):** Hangi katmanlar etkilenecek? (Sadece DB mi, Controller mı, React component'i mi, Inertia payload mu?)
3. **Q3 (Başarı Kriteri):** İşin bittiğini nasıl doğrulayacağız? (Belirli bir test senaryosu, log çıktısı veya performans metriği var mı?)
4. **Q4 (Kısıtlamalar):** Dokunulmaması gereken bağımlılıklar veya mevcut kurallar nelerdir?

## Çıktı Formatı
Soruların yanıtları alındıktan sonra, ajan şu formatta **Güçlendirilmiş Prompt** hazırlar:
```markdown
## 🔍 Input Clarification Result
- **Orijinal Girdi:** "..."
- **Hedef:** ...
- **Kapsam:** ...
- **Kriterler & Kısıtlamalar:** ...
---
### 🎯 Güçlendirilmiş Prompt
[Tüm detayları içeren ve /plan workflow'unu tetiklemeye hazır mimari prompt]