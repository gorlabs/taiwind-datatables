---
title: VCK-v3 Master Index
description: Quick start guide and system roadmap for AI-assisted professional development
version: 3.0
last_updated: 2026-05-03
---

# 🚀 VCK-v3 — Profesyonel Geliştiriciler İçin Akıllı Kod Asistanı

## Sistem Nedir?

VCK-v3, **büyük dil modellerine sahip kod editörleri** (Cursor, Cline, Roo-Code gibi) ile çalışan yazılımcılar için tasarlanmış bir **karar sistematiği**dir. Muğlak promptlardan temiz, çalışan koda ulaşana kadar tüm süreci yapılandırır.

**Temel mantık:**
- 🎯 **Hiçbir tahmin yürütme** — Her yer açık, her adımda soru sorma
- 🔍 **Soru merkezli** — Kodlamadan önce anlamaya odaklanma
- 🧪 **Test odaklı** — Red/Green/Refactor/Quality 4-evre döngüsü
- 🎭 **Persona-tabanlı** — Context'e göre otomatik rol seçimi (Aria/Felix/Bora/Deva/Chronos)
- 🧠 **Yapılandırılmış düşünme** — Sequential Thinking MCP aracı ile derinlemesine analiz

---

## İlk Başlangıç (5 Dakika)

### 1. Sistem Yapısını Anla
.agent/
├── INDEX.md (burası) ← Quick start
├── core-rules.md ← Global kurallar & Persona seçimi
├── workflows/ ← 7 ana iş akışı
├── mcp-integration/ ← MCP araçları nasıl çağrılır
├── personas/ ← 5 Persona tanımı (Aria, Felix, Bora, Deva, Chronos)
├── templates/ ← Tekrar eden yapılar
└── knowledge/ ← Projeye özel bilgiler
### 2. Sistem Nasıl Çalışır?
Her projeniz için bir iş akışı:

CONTEXT LOAD  [Auto]↓INPUT CLARIFICATION  [Muğlak prompt? /clarify]↓BRAINSTORMING  [Fikir mi? /brainstorm]↓PLANNING  [Plan yapma /plan]↓ARCHITECTURE REVIEW  [Denetim /review-arch]↓CODING  [TDE: Red→Green→Refactor→Quality /code]↓FINAL REVIEW  [Son kontrol /review]
### 3. Normal Kullanım Senaryoları

**Senaryo 1: Basit Bug Fix**
Siz: "Auth tokenı 2 saatlik, süresi uzat"Ajan:/clarify otomatik tetiklenirQ1: "Tüm token type'larında mı?"Q2: "Cache invalidation gerekli mi?"Q3: "Log ekleme vs?"→ /plan → /review-arch → /code (TDE)
**Senaryo 2: Yeni Özellik**
Siz: "Dashboard'a analytics widget ekleyelim"Ajan:/brainstorm otomatik tetiklenir"Dashboard'a apa veri kaynakları kullanılacak?""Real-time mi, polled mi?""3 yaklaşım öner"→ Seçim yap → /plan → /review-arch → /code
**Senaryo 3: Teknik Çıkmaz**
Siz: "Bu component'te performance problemi var ama nasıl düzeltecez?"Ajan:/brainstorm → "Hangi metrik problem oluşturuyor? (render time, bundle size?)"Yaklaşımlar: Memoization, Code splitting, Virtual list, vb.→ Seçim → /plan → /review-arch → /code
---

## 7 Ana Workflow (Detaylı)

| # | Workflow | Tetikleyici | Komut | Amaç |
|---|----------|-------------|-------|------|
| 1 | **Auto-Launcher** | Oturum başlangıcı | — | Context yükleme (Sequential Thinking + Codebase Memory) |
| 2 | **Input Clarification** | Muğlak input | `/clarify` | 4 stratejik soru sorarak promptu güçlendir |
| 3 | **Brainstorming** | Fikir/çıkmaz | `/brainstorm` | Multiple yaklaşım öner, Steel-Manning analizi |
| 4 | **Planning** | Plan yapma | `/plan` | Adım adım roadmap + Mermaid diyagram + risk analizi |
| 5 | **Architecture Review** | Plan sonrası | `/review-arch` | 5 persona (Aria/Felix/Bora/Deva/Chronos) perspektifinden denetim |
| 6 | **Coding** | Review ✅ sonrası | `/code` | **TDE 4-evre** (Red/Green/Refactor/Quality) |
| 7 | **Final Review** | Coding bitişi | `/review` | Hijyen, test coverage, docs, güvenlik kontrol |
| 8 | **Learning** | İş bitişi / Feature sonrası | `/learn` | Proje hafızasını güncelle (Lessons Learned) |

**Her workflow detaylı bilgi için:** [workflows/](workflows/) klasörüne bakın.

---

## 5 Persona (Otomatik Seçim)

| Persona | Ne Zaman | Sorumluluk |
|---------|----------|-----------|
| **Aria** (👩‍🎨 UI/UX) | CSS, component, UI logic | Responsive, accessible, premium estetik |
| **Felix** (⚡ Frontend) | JavaScript, state, perf | Performance, modülerlik, best practices |
| **Bora** (🔐 Backend) | API, database, business logic | Security, scalability, reliability |
| **Deva** (🚀 DevOps) | Deploy, CI/CD, monitoring | Infrastructure, monitoring, reliability |
| **Chronos** (🏛️ Architect) | Code review, architecture, mühürleme | Zero-error, Anayasa uyumu, derin kod denetimi ve doğrulama |

**Persona seçimi otomatik:** Context'ten hangi alan etkilendiği algılanır ve o persona aktif olur.
**Override:** Eğer gerekirse, komut yazarken belirtebilirsiniz: `@aria`, `@felix` veya `@chronos`[cite: 12].

---

## MCP Araçları (7 Entegre Tool)

VCK-v3, şu MCP araçlarını akıllıca kullanır[cite: 12]:

| Araç | Kullanım | Workflow |
|------|----------|----------|
| **Sequential Thinking** | Derinlemesine analiz (plan, debug, TDE) | Planning, Architecture Review, Coding[cite: 12] |
| **Codebase Memory** | Context yönetimi | Auto-Launcher, all workflows[cite: 12] |
| **Chrome DevTools MCP** | Frontend validation & performance | Coding (TDE), Final Review[cite: 12] |
| **Context7** | Documentation management | Planning, Architecture Review[cite: 12] |
| **OpenSpec** | Spec-driven development | Brainstorming, Planning[cite: 12] |
| **Penpot** | Design integration | Brainstorming (visual design)[cite: 12] |
| **Superpowers** | Workflow orchestration hints | Meta (system guidance)[cite: 12] |

**Her MCP aracı nasıl kullanılır?** [mcp-integration/](mcp-integration/) klasörüne bakın[cite: 12].

---

## Test-Driven Execution (TDE) — 4-Evre

VCK-v3'ün kalbi TDE döngüsüdür[cite: 12]. `/code` komutu ile başlatılır[cite: 12]:

### ✅ EVRE 1: RED (Test Yazma)
Test yaz veya başarı kriteri belirle[cite: 12]Testi çalıştır ve FAIL aldığını teyit et[cite: 12]Soru: "Bu test yeterli olacak mı? Edge case'ler?"[cite: 12]
### ✅ EVRE 2: GREEN (Kod Yazma)
Sadece testin geçmesi için minimum kod yaz[cite: 12]Sequential Thinking: "Yan etkiler? Hata durumları?"[cite: 12]Testin geçtiğini teyit et[cite: 12]Soru: "Daha basit çözüm var mı?"[cite: 12]
### ✅ EVRE 3: REFACTOR (Temizleme)
Kodu VCK hijyen standardlarına göre temizle[cite: 12]DRY prensibine uy, isimlendirmeleri düzelt[cite: 12]Testlerin hala geçtiğini teyit et[cite: 12]Soru: "Isimlendirmeler NET ve açık mı?"[cite: 12]
### ✅ EVRE 4: QUALITY CHECK
Sequential Thinking: "Premium vibe" açısından kontrol[cite: 12]Logging/error handling iyiyse?[cite: 12]Performance iyiyse? (Chrome DevTools)[cite: 12]Döküm/komentler yeterli mi?[cite: 12]Soru: "Başkası bu kodu okuyabilir mi?"[cite: 12]
---

## Global Rules (Temel Kurallar)

Tüm workflow'lar şu kurallara tabidir[cite: 12]. Detaylı bilgi: [core-rules.md](core-rules.md)[cite: 12]

### 1. **Asla Tahmin Yapma**
- Muğlak prompt → `/clarify` otomatik tetiklenir[cite: 12]
- 4 stratejik soru sorulur[cite: 12]
- Onay alınmadan koda geçilmez[cite: 12]

### 2. **Sequential Thinking Zorunluluğu**
- Planlama öncesi[cite: 12]
- Architecture Review sırasında[cite: 12]
- TDE'de Green aşaması (side effects analizi)[cite: 12]
- Debugging sırasında (root cause analysis)[cite: 12]

### 3. **Test Olmadan Kod Yok**
- Her mantıksal değişiklik = 1 test[cite: 12]
- Manuel kontrol yerine terminal testi[cite: 12]
- Test başarısız → kodu düzeltme, adıma takılı kalma[cite: 12]

### 4. **Kod Hijyeni Ödün Verilmez**
- Gereksiz inline yorum yasak (karmaşık mantık & "Neden?" hariç)[cite: 12]
- DRY prensibi kesin[cite: 12]
- Isimlendirmeler net ve açık[cite: 12]
- `.env` kullanımı zorunlu (secrets)[cite: 12]

### 5. **Onay Mekanizması**
- Plan → "Onaylıyor musunuz?" (evet alıncaya kadar kod yok)[cite: 12]
- Architecture Review → "✅ Onaylı" (evet alıncaya kadar coding yok)[cite: 12]
- Hata = başarısız adıma dön (skip yok)[cite: 12]

---

## Hızlı Referans (Komutlar)

/primer           → Context load (oturum başında auto)[cite: 12]
/clarify          → Muğlak input'ı güçlendir[cite: 12]
/brainstorm       → Fikir tartışması[cite: 12]
/plan             → Plan yapma[cite: 12]
/review-arch      → Architecture denetimi[cite: 12]
/code             → TDE: Red/Green/Refactor/Quality[cite: 12]
/review           → Final review[cite: 12]
/learn            → Knowledge Base güncelle[cite: 12]
---

## Projeye Özel Bilgi (Knowledge Base)

[.agent/knowledge/INDEX.md](knowledge/INDEX.md) içinde[cite: 12]:
- Proje-spesifik kararlar[cite: 12]
- Known bugs & gotchas[cite: 12]
- Tech stack conventions[cite: 12]
- Deprecated patterns[cite: 12]

---

## İleri Okuma

- 📋 [core-rules.md](core-rules.md) — Global directives, Persona seçimi, Soru matrisleri[cite: 12]
- 🔄 [workflows/](workflows/) — 7 workflow detaylı[cite: 12]
- 🔗 [mcp-integration/](mcp-integration/) — MCP araçları nasıl çağrılır[cite: 12]
- 👥 [personas/](personas/) — 5 Persona tanımı[cite: 12]
- 📝 [templates/](templates/) — Tekrar eden yapılar[cite: 12]

---

## Sistem Felsefesi

> "Akıllı asistan kod yazmaz. Sorular sorarak, fikri olgunlaştırıp, testleri yazıp, kodu adım adım güçlendirir. Hata ise kök nedenden çözer. Premium ve güvenilir sonuç çıkar[cite: 12]."

**VCK-v3 geliştiricinin uzantısıdır. Yönetici değil[cite: 12].**

---

**Sonraki adım:** Kodlamaya başlamış mısınız? `/clarify` ile başlayın veya `/plan` ile doğrudan plan yapın[cite: 12].

Sorularınız mı var? Baştan başlamak mı istiyorsunuz? `/primer` yazın[cite: 12]. 🎯