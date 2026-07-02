# 🛡️ GLOBAL PROJE EGEMEN EKOSİSTEMİ DEĞİŞMEZ ANAYASASI
Versiyon: 1.0.0 — Global Master Template
Durum: IMMUTABLE

Madde I: TDD Geçidi ve Kod Bütünlüğü
§1.1 İlgili davranışı veya hatayı doğrulayan bir başarısız test (Red Phase) yazılmadan hiçbir üretim kodu yazılamaz, değiştirilemez veya birleştirilemez.
§1.2 Sıfır Yer Tutucu (Placeholder) Politikası: `pass`, `TODO`, `FIXME` ifadeleri yasaktır. Tamamlanmamış kodlar açıkça hata (Exception) fırlatmalıdır.

Madde II: Modüler Egemenlik ve Ajan Sınırları
§2.1 Modüller birbirlerinin dahili alanlarına doğrudan müdahale edemez. İletişim soyut katmanlar (API/IPC/Interfaces) üzerinden yürütülür.
§2.2 Yapay zeka halüsinasyonlarını engellemek amacıyla; fonksiyonlar maksimum 30 satır, dosyalar veri modelleri hariç maksimum 200 satır sınırına tabidir.

Madde III: SOLID ve Mimari Emirler
§3.1 Tek Sorumluluk: Her katman ve sınıfın yalnızca tek bir mimari kaygısı olmalıdır.
§3.2 Bağımlılıkların Tersine Çevrilmesi: Kod somutlamalara değil, soyut kontratlara (Interfaces) bağımlı olmalı ve enjeksiyon mimarisi kullanılmalıdır.

Madde IV: Gizlilik ve Ortam Güvenliği
§4.1 Çevre ve `.env` dosyaları otomasyon süreçlerinde korunmalı, gizli anahtarlar asla hardcode edilmemeli ve merkezi kasalardan/config yapılarından beslenmelidir.