# 🔗 GLOBAL MCP ARAÇLARI — ENTEGRASYON VE ÇAĞRI REHBERİ
Versiyon: 1.0.0 — Global Master Template
Durum: ONAYLANDI

Bu rehber, yapay zeka ajanının (AI) herhangi bir yazılım projesinde çalışırken ekosistem araçlarını (MCP) hangi iş akışında, ne zaman ve nasıl çağıracağını belirleyen evrensel protokol kılavuzudur.

---

## 🛠️ Küresel MCP Araç Matrisi

| # | Araç Adı | Çekirdek Amaç | Kritik Entegrasyon Fazı |
|---|---|---|---|
| 1 | **Sequential Thinking** | Adım adım derinlemesine problem çözme, risk analizi | Planlama, Hata Ayıklama, Mimari İnceleme |
| 2 | **Codebase Memory** | Proje bağlamı yükleme, kod kalıplarını tarama | Oturum Başlangıcı, Bağımlılık Analizi |
| 3 | **Chrome DevTools MCP** | Arayüz performans ve render doğrulama | Kalite Kontrol (QA), Son İnceleme |
| 4 | **Context7** | Bilgi tabanı ve dökümantasyon senkronizasyonu | Planlama, Teslimat / Kapanış Fazı |
| 5 | **OpenSpec** | Teknik spesifikasyon ve gereksinim dökümü | Beyin Fırtınası, Biçimsel Planlama |
| 6 | **Penpot** | Kullanıcı arayüzü ve görsel prototip entegrasyonu | Tasarım Doğrulama, Tel Kafes (Wireframe)[cite: 21, 24] |
| 7 | **Superpowers** | İş akışı orkestrasyonu ve üst düzey rehberlik | Tüm Meta Süreçler |

---

## 🔄 İş Akışı Dağılım Matrisi

┌─────────────────────────────────────────────────────────────┐
│ WORKFLOW FAZLARINA GÖRE EVRENSEL MCP KULLANIMI             │
├──────────────────┬──────────────────────────────────────────┤
│ Başlatıcı        │ Sequential Thinking, Codebase Memory     │
├──────────────────┼──────────────────────────────────────────┤
│ Gereksinim       │ Sequential Thinking, OpenSpec, Penpot    │
├──────────────────┼──────────────────────────────────────────┤
│ Planlama         │ Seq.Thinking, OpenSpec, Context7         │
├──────────────────┼──────────────────────────────────────────┤
│ Mimari İnceleme  │ Sequential Thinking, Codebase Memory     │
├──────────────────┼──────────────────────────────────────────┤
│ Geliştirme (Kod) │ Sequential Thinking, Chrome DevTools     │
├──────────────────┼──────────────────────────────────────────┤
│ Son Gözden Geçirme│ Seq.Thinking, Chrome DevTools, Context7  │
└──────────────────┴──────────────────────────────────────────┘


---

## 🚨 Ajan İçin Temel Kurallar (Mandatory Rules)
1. **Şeffaf Beyan:** Ajan, bir işlemi yaparken hangi MCP aracını, hangi somut gerekçeyle çağırdığını kullanıcıya açıkça bildirmelidir[cite: 21].
2. **Yeterli Bağlam sağlama:** MCP araçlarına gönderilen sorgular muğlak olamaz; hedef dosya yolları, beklenen çıktılar ve kısıtlar argüman olarak verilmelidir[cite: 21].
3. **Kalıcı Mühürleme:** MCP araçlarından dönen kritik çıktılar ve raporlar, projenin ilgili dökümantasyon alanlarına (bilgi tabanına) işlenmelidir[cite: 21].