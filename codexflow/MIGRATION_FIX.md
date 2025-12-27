# 🔧 Migration Sorunu Düzeltmesi

## Sorun
```
SQLSTATE[42703]: Undefined column: 7 ERROR: column "is_admin" of relation "users" does not exist
```

## Çözüm

Migration henüz çalıştırılmamış. Önce migration'ı çalıştırın:

```bash
php artisan migrate
```

Veya sadece bu migration'ı çalıştırın:

```bash
php artisan migrate --path=database/migrations/2025_12_27_135917_add_is_admin_to_users_table.php
```

## Adımlar

### 1. Migration Çalıştır
```bash
php artisan migrate
```

### 2. Admin Kullanıcısı Oluştur
```bash
php artisan db:seed --class=AdminUserSeeder
```

## Alternatif: Manuel SQL

Eğer migration çalışmazsa, direkt SQL ile kolon ekleyebilirsiniz:

```sql
ALTER TABLE users ADD COLUMN is_admin BOOLEAN DEFAULT false;
```

Sonra seeder'ı çalıştırın:
```bash
php artisan db:seed --class=AdminUserSeeder
```

