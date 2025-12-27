# 🔍 Admin Panel 500 Error - Tanılama Rehberi

## Hata Kontrol Adımları

### 1. Log Dosyasını Kontrol Et

Easypanel Terminal'den:

```bash
tail -n 50 storage/logs/laravel.log
```

Veya son 100 satır:

```bash
tail -n 100 storage/logs/laravel.log | grep -A 10 -B 10 "Admin"
```

### 2. Migration Kontrolü

```bash
php artisan migrate:status
```

`is_admin` migration'ının çalıştığını kontrol edin.

### 3. Database Kolon Kontrolü

```bash
php artisan tinker
```

```php
// PostgreSQL için
\DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = 'users' AND column_name = 'is_admin'");

// Veya direkt kontrol
$user = \App\Models\User::first();
var_dump(isset($user->is_admin));
```

### 4. Route Kontrolü

```bash
php artisan route:list | grep admin
```

Admin route'larının kayıtlı olduğunu kontrol edin.

### 5. Middleware Kontrolü

```bash
php artisan route:list --path=admin
```

## Hızlı Düzeltme Komutları

### Tüm Düzeltmeleri Uygula

```bash
# 1. Migration çalıştır
php artisan migrate

# 2. Cache temizle
php artisan optimize:clear

# 3. Config cache
php artisan config:cache

# 4. Route cache
php artisan route:cache

# 5. View cache
php artisan view:cache
```

### Manuel SQL (Eğer migration çalışmazsa)

```sql
-- PostgreSQL
ALTER TABLE users ADD COLUMN IF NOT EXISTS is_admin BOOLEAN DEFAULT false;

-- Kontrol
SELECT column_name, data_type, column_default 
FROM information_schema.columns 
WHERE table_name = 'users' AND column_name = 'is_admin';
```

## Yaygın Hatalar ve Çözümleri

### Hata 1: "Column is_admin does not exist"
**Çözüm:** Migration çalıştır
```bash
php artisan migrate
```

### Hata 2: "Class AdminController does not exist"
**Çözüm:** Autoload yenile
```bash
composer dump-autoload
```

### Hata 3: "View [admin.index] not found"
**Çözüm:** View dosyası kontrolü
```bash
ls -la resources/views/admin/
```

### Hata 4: "Call to undefined method is_admin"
**Çözüm:** Model'de fillable'a ekle ve migration çalıştır
```bash
php artisan migrate
```

## Debug Mode Açma

Geçici olarak debug mode açın (production'da dikkatli kullanın):

```env
APP_DEBUG=true
```

Sonra tekrar deneyin ve detaylı hata mesajını görün.

## Test

1. Login: `/login`
2. Admin bilgileriyle giriş
3. Admin Panel: `/admin`

Eğer hala 500 hatası varsa, log dosyasındaki tam hata mesajını paylaşın.

