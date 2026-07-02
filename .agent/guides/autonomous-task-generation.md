# 🛡️ VCK-v3 — OTONOM GÖREV ÜRETİM PROTOKOLÜ (MASTER TEMPLATE)

Bu protokol, Baş Mimar'dan gelen her türlü "Yeni Özellik" veya "Hata Düzeltme" isteğini; analiz, denetim, TDE ve mühürleme aşamalarından geçirecek olan **Standart Görev Promptu**'dur.

## 1. BAŞLANGIÇ (ROOT PROTOCOL)
- Anayasa'yı, AGENTS.md'yi, `wiki/ledger` ve .agent altındaki tüm dosyaları oku.
- `wiki/failed_attempts.md` dosyasını Madde 17 gereği zorunlu olarak tara.
- Görevi asla doğrudan kodlamaya başlama, her zaman S1 (INTAKE) ile gir.

## 2. ADIM 0 — X-RAY ANALİZ (PLANLAMADAN ÖNCE)
- Görevin etki alanındaki yetki matrisini ve bağımlılıkları fiziksel kod okuma ile doğrula.
- "Mevcut Sistemi Anlıyorum" başlığı altında, varsayım yapmadan somut dosya referanslarıyla (örn: `Gate::define`, `Policy` dosyası, `Component` prop yapısı) dokümante et.

## 3. 📋 YETKİ VE İZOLASYON ZIRHI
- Tüm işlemler için mevcut Gate/Policy/Permission mekanizmasını kullan. `if/else` yetki kontrolü YASAKTIR.
- Clan/Kingdom/Team ID'leri asla hardcode etme.
- "Genişletme/Daraltma" kısıtlamalarına harfiyen uy.

## 4. 📐 GÖREV AKIŞI (WORKFLOW)
- **ADIM 1 (/plan):** `planning.md` + Yetki Matrisi + Risk Haritası + Mermaid Diyagramı. Kayıt: `agent/plans/feat_*.md`.
- **ADIM 2 (/review-arch):** 5 Persona (Aria, Felix, Bora, Deva, Chronos) denetimi. ✅ Onay almadan asla /code'a geçme.
- **ADIM 3 (/code):** TDE (Red-Green-Refactor-Quality). Her adımda terminal kanıtı (Zero-Trust) sun.

## 5. ⚠️ MUTLAK KISITLAMALAR (THE UNBREAKABLES)
- ZERO-HARDCODE: (IP, ID, Paths yasak).
- MODAL/TABLO: ConfirmDeleteModal kullanımı, Inertia partial reloads.
- Raporlama: Tüm süreç `.agent/agent/plans/*.md` içine fiziksel olarak mühürlenecek.
- TDD: Test yazılmadan implementasyon yapılamaz.

---

[BAŞ MİMAR: Buraya özelleştirilmiş feature detaylarını ekleyin]

Göreve başla. İlk çıktın "Mevcut Sistemi Anlıyorum" özetiyle başlayan /plan aşaması olacak.
