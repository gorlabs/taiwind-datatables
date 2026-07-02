---
name: brainstorming
description: Alternatif çözümler üretme ve Steel-Manning analizi
global_framework: AI_Forge
---

# 💡 Workflow: /brainstorm (Brainstorming)

**Tetikleyici:** `/brainstorm` komutu veya karmaşık bir mimari karar anı.
**Amaç:** Tek bir çözüme saplanıp kalmamak için en az 2-3 farklı teknik yaklaşım üretmek ve en zayıf görünen fikri en güçlü haliyle savunarak (Steel-Manning) çarpıştırmak.

---

## Aşama 1: Yaklaşımların Çıkarılması
Ajan, hedefe ulaşmak için en az 2, ideal olarak 3 farklı implementasyon yolu sunar:
- **Yaklaşım A:** (Örn: Kısa vadeli, düşük maliyetli, geçici çözüm)
- **Yaklaşım B:** (Örn: Tamamen SOLID uyumlu, refactor gerektiren, kalıcı çözüm)
- **Yaklaşım C:** (Örn: Event-driven veya alternatif kütüphane odaklı yaklaşım)

## Aşama 2: Pro/Con ve Efor Matrisi
Her bir yaklaşım için:
- **Artılar (Pros):** ...
- **Eksiler (Cons):** ...
- **Efor:** (Low / Medium / High)

## Aşama 3: Steel-Manning Analizi
Ajan, kendi içlerinden en çok eleştiriye açık olan yaklaşımı seçer. Onun zayıflıklarını gizlemek yerine, o zayıflıkların nasıl domine edilebileceğini ve fikrin en optimize nasıl çalışabileceğini rasyonel olarak savunur.

## Aşama 4: Seçim ve Kapı
Kullanıcıya yaklaşımlar özetlenir ve bir seçim yapması istenir. Seçim yapıldıktan sonra `/plan` aşamasına geçilir.