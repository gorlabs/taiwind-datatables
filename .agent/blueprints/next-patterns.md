# Global Next.js ve TypeScript Desenleri

## 🚀 Çekirdek Paradigma
* **App Router:** Next.js App Router standartlarını (`app/` dizini) kullan. Varsayılan olarak sunucu bileşenlerini (Server Components) tercih et; istemci bileşenlerini (`'use client'`) yalnızca etkileşim (interactivity) gerektiğinde kullan.
* **Veri Çekme (Data Fetching):** Next.js önbellekleme ve yeniden doğrulama (revalidation) stratejilerine sahip yerel `fetch` yapısını kullan (`next: { revalidate: 3600 }`). Kesinlikle gerekli olmadıkça Axios gibi harici kütüphaneler kullanmaktan kaçın.

## 🔒 Tip Güvenliği (Type Safety)
* **Sıkı TypeScript (Strict):** Sıkı tip denetimini zorunlu kıl. `any` tipini kullanmaktan kaçın. Sunucu yanıtları ve bileşen prop'ları için interface ve type tanımlamalarını eksiksiz yap.