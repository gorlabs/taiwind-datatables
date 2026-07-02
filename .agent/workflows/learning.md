---
name: learning
description: Proje hafızasını kalıcılaştırma (Lessons Learned)
template: templates/knowledge-entry.md
global_framework: AI_Forge
---

# 🧠 Workflow: /learn (Knowledge Learning)

**Tetikleyici:** Kritik bir bug çözüldüğünde, büyük bir özellik tamamlandığında veya manuel `/learn` komutuyla.
**Amaç:** Yaşanan tecrübeleri, yapılan hataları ve mimari kararları projenin yerel hafızasına kalıcı olarak işlemek; gelecekte aynı hatayı tekrarlamamak.

---

## Akış Adımları
1. **Analiz:** Karşılaşılan teknik zorluk, denenen hatalı yollar ve nihai çözüm tespit edilir.
2. **Drafting:** Global `templates/knowledge-entry.md` şablonu doldurulur:
    - **Type:** (decision | convention | bug | gotcha | deprecated)
    - **Topic:** Kısa, öz başlık.
    - **Context:** Sorunun arka planı.
    - **Solution:** Uygulanan çözüm ve altın değerindeki kod bloğu.
    - **Status:** Active
3. **Onay & Kayıt:** Ajan, içeriği kullanıcıya özetler. Kullanıcı "Kaydedilsin mi?" sorusuna onay verdiğinde dosya, projenin yerel `.agent/knowledge/` klasörüne (Örn: `auth-token-caching.md`) kaydedilir ve projedeki `INDEX.md` güncellenir.