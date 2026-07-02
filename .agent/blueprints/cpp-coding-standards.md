# 🛡️ VCK-v3 — OTONOM GÖREV ÜRETİM PROTOKOLÜ (GLOBAL MASTER TEMPLATE)

Bu protokol, Baş Mimar'dan gelen her türlü "Yeni Özellik" veya "Hata Düzeltme" isteğini; analiz, denetim, TDE (Test-Driven Execution) ve mühürleme aşamalarından geçirecek olan **Standart Görev Yönetim Motoru**'dur.

## 1. BAŞLANGIÇ (ROOT PROTOCOL)
- Projenin ana kurallarını, ajan talimatlarını (`AGENTS.md`) ve kök dizindeki tüm rehber dökümanları oku.
- Varsa geçmiş krizlerin ve alınan derslerin toplandığı geçmiş günlükleri (`failed_attempts.md`) zorunlu olarak tara.
- Görevi asla doğrudan kodlamaya başlama, her zaman durum analizi ile gir.

## 2. ADIM 0 — X-RAY ANALİZ (PLANLAMADAN ÖNCE)
- Görevin etki alanındaki yetki matrisini, mimari sınırları ve bağımlılıkları fiziksel kod okuma ile doğrula.
- "Mevcut Sistemi Anlıyorum" başlığı altında, varsayım yapmadan somut dosya ve kod referanslarıyla mevcut durumu dokümante et.

## 3. 📋 YETKİ VE İZOLASYON ZIRHI
- Tüm işlemler için projenin mevcut güvenlik, rol ve yetkilendirme mekanizmalarını kullan. Kod düzeyinde `if/else` ile bypass veya hardcode yetki kontrolleri yapmak YASAKTIR.
- Projedeki izolasyon kurallarına (Tenant/Team/Kullanıcı sınırları) harfiyen uy.

## 4. 📐 GÖREV AKIŞI (WORKFLOW)
- **ADIM 1 (/plan):** Yol haritası + Etki/Yetki Matrisi + Risk Haritası belirle.
- **ADIM 2 (/review-arch):** Mimari, frontend, backend, siber güvenlik ve operasyonel açılardan (Persona süzgeçlerinden) denetim yap. ✅ Kullanıcıdan onay almadan asla kodlama fazına geçme.
- **ADIM 3 (/code):** TDE (Red-Green-Refactor-Quality) döngüsünü işlet. Her adımda terminal testi çıktısını (Zero-Trust) kanıt olarak sun.
- **ADIM 4 (/seal):** Görev başarıyla tamamlandığında, yapılan kalıcı mimari değişiklikleri ve kararları projenin mühürlü döküm günlüğüne (`approved.md`) işlemesi için Baş Mimar'a (Kullanıcıya) sun.