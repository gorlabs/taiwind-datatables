# Global Python ve FastAPI Performans Standartları

## ⚡ Asenkron Mimari
* Veritabanı sorguları veya ağ istekleri içeren, asenkron Girdi/Çıktı (I/O) barındıran tüm rota yönlendiricileri (route handlers) için her zaman `async def` kullan.
* Standart senkron tanımlamaları (`def`) yalnızca CPU yoğunluklu görevler veya engellemeyen (non-blocking) yardımcı araçlar için kullan.

## 🛡️ Veri Doğrulama (Data Validation)
* **Pydantic v2** kullanarak sıkı tip açıklamalarını ve şemalarını zorunlu kıl.
* Tüm istek gövdeleri (request bodies) ve ortam yapılandırmaları, doğrulanmış Pydantic modelleriyle eşleşmelidir.