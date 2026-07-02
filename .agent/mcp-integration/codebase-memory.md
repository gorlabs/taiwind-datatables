# 💾 MCP: Codebase Memory (Kod Tabanı Hafızası)
name: codebase-memory
description: Proje bağlamını yükleme, mevcut tasarım kalıplarını ve bağımlılıkları haritalandırma aracı

---

## 🎯 Ne Zaman Çağrılır?
- ✅ Yeni bir çalışma oturumu başlangıcında (Context Loading)[cite: 19, 21].
- ✅ Yeni bir özellik eklemeden önce mevcut kod kalıplarını (design patterns) öğrenmek için.
- ✅ Yeniden yapılandırma (refactoring) öncesi bağımlılık analizi yaparken[cite: 19, 21].

---

## 💬 Çağrı Protokolü

"Codebase Memory MCP'sini kullanarak hedef sistemdeki mevcut yapıyı analiz et:  Sorgu Hedefleri:  Projede uygulanan genel hata yakalama (error handling) ve girdi doğrulama (validation) kalıpları nelerdir?  [İlgili Modül/Özellik] daha önce sistemde nasıl kurgulanmıştır, benzer bir implementasyon örneği var mı?  Son değişikliklerden etkilenmesi muhtemel dosyalar ve bağımlılık zinciri nedir?[cite: 19]Beklenen: Mevcut kod örnekleri ve dosya yolları ile desteklenmiş bağlam raporu."[cite: 19]