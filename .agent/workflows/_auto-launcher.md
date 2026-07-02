---
name: auto-launcher
description: Context loading workflow - triggered at session start
global_framework: AI_Forge
---

# 🔄 Workflow: /primer (Auto-Launcher)

**Tetikleyici:** Oturum başlangıcı veya `/primer` komutu (Otomatik/Manuel)
**Amaç:** Proje bağlamını yükle, tech stack ve mevcut durumu anla, personayı seç.
**Süre:** 30-60 saniye (Sessiz arka plan analizi)

---

## Giriş Talimatı
"Proje bağlamını AI_Forge VCK-v3 protokolüne göre yükle. Aşağıdaki adımları sırasıyla uygula:"

## Adım 1: Keşif ve Analiz
1. Kök dizini listele (`ls -la` veya `tree -L 2`).
2. Tech stack tespiti yap:
    - `composer.json` (Laravel & PHP sürümü kontrolü - Laravel 13 guard)
    - `package.json` (React, Inertia, Tailwind kontrolü)
    - `.env.example` ve mevcut konfigürasyon yapıları.

## Adım 2: Durum ve Hafıza Tespiti
1. `.agent/knowledge/INDEX.md` veya `.agent/knowledge/failed_attempts.md` dosyalarını oku.
2. Son commit'leri ve mevcut git durumunu analiz et (`git status`, `git log -n 3`).

## Adım 3: Persona Seçimi
Context'e göre otomatik persona değiştir:
- Backend / API / Veritabanı ağırlıklı işler ise ➡️ **Bora**
- UI / CSS / Responsive / Tasarım ağırlıklı işler ise ➡️ **Aria**
- JavaScript / React / State Management / Inertia ağırlıklı işler ise ➡️ **Felix**
- Deploy / CI-CD / Bash / Server / CloudPanel ağırlıklı işler ise ➡️ **Deva**
- Belirsizlik durumunda kullanıcıya mevcut personayı bildir.

## Başarı Kriterleri
- ✅ Proje bağlamı ve dizin haritası yüklendi.
- ✅ Laravel 13, React, Inertia stack doğrulaması yapıldı.
- ✅ Güncel görev ve kalınan yer tespit edildi.
- ✅ Uygun persona aktif edildi.
- ✅ Kullanıcıya `## 🟢 Context Loaded` çıktısı üretildi.