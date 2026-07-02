# 🧠 MCP: Sequential Thinking (Ardışık Derin Düşünme)
name: sequential-thinking
description: Karmaşık problemleri, mimari kararları ve riskleri adım adım analiz etme aracı[cite: 21]

---

## 🎯 Kullanım Bariyerleri ve Zorunluluklar
Aşağıdaki senaryolarla karşılaşıldığında bu MCP aracının tetiklenmesi **ZORUNLUDUR**:
- ⚠️ Sistem mimarisini etkileyen, geriye dönük uyumluluğu (breaking changes) riske atan kararlardan önce.
- ⚠️ Kritik güvenlik, yetkilendirme veya veri tabanı şeması değişikliklerinde.
- ⚠️ Test süreçlerinde ortaya çıkan ve yan etkileri (side effects) kestirilemeyen regresyonların çözümünde[cite: 21].

---

## 💬 Çağrı Protokolü

"Sequential Thinking MCP'sini kullanarak aşağıdaki mimari kararı/sorunu analiz et:[cite: 21]

Sorun/Karar: [Değişikliğin veya hatanın tanımı][cite: 21]
Bağlam: [Teknolojik altyapı ve ilgili bileşenler][cite: 21]

Yanıtlanması Zorunlu Sorular:

[cite: 21]

Bu değişikliğin veri tutarlılığına ve mevcut veri tabanına etkisi nedir?[cite: 21]

Bağımlı olan diğer servislerde/modüllerde ne gibi yan etkiler oluşabilir?[cite: 21]

Hata durumunda uygulanacak geri alma (rollback) ve fallback stratejisi nedir?

Beklenen: Adım adım derinlemesine yapılandırılmış analiz raporu."[cite: 21]


---

## 📊 Standart Çıktı Mimarisi

🔍 ARDIŞIK DÜŞÜNME ANALİZ RAPORU

[Soru 1 Yanıtı ve Teknik Detayları][cite: 21]

Olası Riskler: [Risk tanımı][cite: 21]

Hafifletme (Mitigation): [Riski azaltma yöntemi][cite: 21]

[Soru 2 Yanıtı ve Teknik Detayları][cite: 21]

...

SONUÇ VE ÖNERİ:

Risk Seviyesi: [CRITICAL / HIGH / MEDIUM / LOW][cite: 21]

Tavsiye Edilen Aksiyon: [Ajanın mimari kararı][cite: 21]