# 🔧 Admin Panel 500 Error Düzeltmesi

## Sorun
Admin paneli `/admin` route'unda 500 Server Error veriyor.

## Nedenler

1. **Migration Çalıştırılmamış:** `is_admin` kolonu database'de yok
2. **Middleware Hatası:** `is_admin` kolonu yokken erişim denemesi

## Çözüm

### Adım 1: Migration Çalıştır

Easypanel Terminal'den:

```bash
php artisan migrate
```

Veya sadece admin migration'ı:

```bash
php artisan migrate --path=database/migrations/2025_12_27_135917_add_is_admin_to_users_table.php
```

### Adım 2: Manuel SQL (Eğer migration çalışmazsa)

```sql
ALTER TABLE users ADD COLUMN IF NOT EXISTS is_admin BOOLEAN DEFAULT false;
```

### Adım 3: Admin Kullanıcısı Oluştur

```bash
php artisan db:seed --class=AdminUserSeeder
```

### Adım 4: Cache Temizle

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

## Test

1. Login sayfasına gidin: `/login`
2. Admin bilgileriyle giriş yapın:
   - Email: `admin@codexflow.dev`
   - Şifre: `Admin123!`
3. Admin Panel'e gidin: `/admin`

## Güvenlik Notu

Middleware güncellendi ve artık `is_admin` kolonu yoksa bile hata vermeyecek, sadece 403 döndürecek.

