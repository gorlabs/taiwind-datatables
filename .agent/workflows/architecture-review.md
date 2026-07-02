---
name: architecture-review
description: Tasarlanan planın 4 kıdemli persona gözünden denetlenmesi
global_framework: AI_Forge
---

# 🛡️ Workflow: /review-arch (Architecture Review)

**Tetikleyici:** Planlama sonrası otomatik veya manuel `/review-arch`.
**Amaç:** Hazırlanan planı kodlamaya geçmeden önce 4 farklı uzmanlık perspektifinden denetlemek ve `APPROVED` / `NEEDS REVISION` kararı vermek.

---

## 4 Persona Denetim Kriterleri

### 🎨 ARIA (UI/UX Perspektifi)
- Değişiklikler kullanıcı deneyimini, sayfa geçişlerini (Inertia progress) olumsuz etkiliyor mu?
- Loading state'ler, hata mesajları, responsive uyumluluk hesaba katılmış mı? Vibe check premium mi?

### ⚡ FELIX (Frontend/State Perspektifi)
- React tarafında gereksiz re-render riski var mı? (`useCallback`, `useMemo` ihtiyacı?)
- Inertia payload'u optimize mi, yoksa frontend'e gereksiz büyük bir veri mi taşınıyor?

### 🛡️ BORA (Backend/Security Perspektifi)
- Laravel 13 standartlarına, Eloquent optimizasyonuna (N+1 query kontrolü) uygun mu?
- Mass assignment, validation, SQL Injection ve yetkilendirme (Policies) önlemleri tam mı?

### 🚀 DEVA (DevOps/Infrastructure Perspektifi)
- CloudPanel veya sunucu konfigürasyonunu etkileyen bir durum var mı?
- `.env` güvenliği ihlal ediliyor mu? Rsync deployment script'ini tetikleyecek dosya yapısı stabil mi?

## Karar Mekanizması
- 4 personadan da onay alınırsa ➡️ `🎯 Overall Status: ✅ APPROVED` -> `/code` akışına geçilir.
- Bir personada risk görülürse ➡️ `🎯 Overall Status: ⚠️ NEEDS REVISION` -> Plana geri dönülür, revize edilir.