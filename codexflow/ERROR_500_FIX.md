# 🔧 500 Server Error Düzeltmesi

## Sorun
500 Server Error alınıyor.

## ✅ YAPILAN DÜZELTMELER

### 1. Vite Directive Sorunu (DÜZELTİLDİ)
**Sorun:** `@vite` directive production'da build edilmiş assets gerektiriyordu.

**Çözüm:** `@vite` kaldırıldı, Tailwind CSS CDN kullanılıyor.

**Değişen Dosyalar:**
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/dashboard.blade.php`

## 🔍 Diğer Olası Nedenler

### 1. APP_KEY Eksik veya Yanlış
**En yaygın neden!**

Easypanel'de environment variables'da:
```env
APP_KEY=base64:... (php artisan key:generate --show ile oluşturun)
```

Bu placeholder, gerçek bir key olmalı!

**Çözüm:**
```bash
# Easypanel Terminal'den
php artisan key:generate --show
```

Çıkan key'i environment variables'a ekleyin.

### 2. View Dosyası Bulunamıyor
Layout veya view dosyaları eksik olabilir.

**Kontrol:**
```bash
ls -la resources/views/layouts/
ls -la resources/views/auth/
```

### 3. Database Bağlantı Hatası
Database credentials yanlış olabilir.

**Kontrol:**
```bash
php artisan db:show
```

### 4. Permission Hatası
Storage veya cache klasörlerinde permission sorunu.

**Çözüm:**
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 5. Cache Sorunu
Eski cache dosyaları sorun çıkarıyor olabilir.

**Çözüm:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

## 🚀 Hızlı Düzeltme Adımları

### Adım 1: Logs Kontrol
Easypanel'de **Logs** sekmesine gidin ve hata mesajını okuyun.

### Adım 2: APP_KEY Oluştur
```bash
php artisan key:generate --show
```

Çıkan key'i environment variables'a ekleyin.

### Adım 3: Cache Temizle
```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Adım 4: Permissions Düzelt
```bash
chmod -R 755 storage bootstrap/cache
```

### Adım 5: Test
```
https://codexflow-dashboard-codexflow-dashboardpro.lc58dd.easypanel.host/up
```

Bu endpoint çalışıyorsa, ana sayfa sorununu kontrol edin.

## 📝 Debug Mode Aç

Geçici olarak debug mode açın:
```env
APP_DEBUG=true
APP_ENV=local
```

**DİKKAT:** Production'da `APP_DEBUG=false` olmalı!

## 🔍 Log Dosyası Kontrol

```bash
tail -f storage/logs/laravel.log
```

Hata mesajını buradan görebilirsiniz.

---

**En yaygın sorun APP_KEY eksikliğidir! Önce onu kontrol edin.**

