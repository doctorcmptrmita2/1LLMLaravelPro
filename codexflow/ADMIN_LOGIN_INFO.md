# 🔐 Admin Panel Giriş Bilgileri

## Varsayılan Admin Kullanıcısı

### Giriş Bilgileri
- **Email:** `admin@codexflow.dev`
- **Şifre:** `Admin123!`
- **URL:** `https://codexflow-dashboard-codexflow-dashboardpro.lc58dd.easypanel.host/login`

## ⚠️ ÖNEMLİ GÜVENLİK UYARISI

**Production ortamında mutlaka şifreyi değiştirin!**

## Admin Kullanıcısı Oluşturma

### Yöntem 1: Seeder ile (Önerilen)

```bash
php artisan db:seed --class=AdminUserSeeder
```

Veya tüm seeder'ları çalıştır:
```bash
php artisan db:seed
```

### Yöntem 2: Tinker ile

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@codexflow.dev',
    'password' => \Hash::make('Admin123!'),
    'api_key' => 'cf_' . bin2hex(random_bytes(32)),
    'plan' => 'agency',
    'status' => 'active',
    'is_admin' => true,
]);
```

### Yöntem 3: Mevcut Kullanıcıya Admin Yetkisi Verme

```bash
php artisan tinker
```

```php
$user = \App\Models\User::where('email', 'doctor.cmptr.mita2@gmail.com')->first();
if ($user) {
    $user->update(['is_admin' => true]);
    echo "Admin yetkisi verildi!";
} else {
    echo "Kullanıcı bulunamadı!";
}
```

### Yöntem 4: SQL ile

```sql
-- Yeni admin kullanıcısı
INSERT INTO users (name, email, password, api_key, plan, status, is_admin, created_at, updated_at)
VALUES (
    'Admin',
    'admin@codexflow.dev',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- Admin123!
    'cf_' || substr(md5(random()::text), 0, 32),
    'agency',
    'active',
    true,
    NOW(),
    NOW()
);

-- Veya mevcut kullanıcıya admin yetkisi
UPDATE users SET is_admin = true WHERE email = 'doctor.cmptr.mita2@gmail.com';
```

## Admin Paneline Erişim

1. **Login sayfasına gidin:**
   ```
   https://codexflow-dashboard-codexflow-dashboardpro.lc58dd.easypanel.host/login
   ```

2. **Admin bilgileriyle giriş yapın:**
   - Email: `admin@codexflow.dev`
   - Şifre: `Admin123!`

3. **Dashboard'a giriş yaptıktan sonra:**
   - Sidebar'da **"Admin Panel"** linki görünecek
   - Veya direkt: `/admin`

## Şifre Değiştirme

### Web Interface'den
1. Admin Panel'e giriş yapın
2. Dashboard → Settings
3. Şifre değiştirme (eğer implement edildiyse)

### Tinker ile
```bash
php artisan tinker
```

```php
$user = \App\Models\User::where('email', 'admin@codexflow.dev')->first();
$user->update(['password' => \Hash::make('YENİ_GÜÇLÜ_ŞİFRE')]);
echo "Şifre güncellendi!";
```

## Güvenlik Önerileri

1. ✅ **Production'da mutlaka şifreyi değiştirin**
2. ✅ **Güçlü şifre kullanın** (min 12 karakter, büyük/küçük harf, rakam, özel karakter)
3. ✅ **2FA ekleyin** (opsiyonel, gelecekte implement edilebilir)
4. ✅ **Admin kullanıcı sayısını sınırlayın**
5. ✅ **Düzenli olarak log kontrolü yapın**

## Sorun Giderme

### "Admin Panel" linki görünmüyor
- Kullanıcının `is_admin = true` olduğundan emin olun
- Cache'i temizleyin: `php artisan cache:clear`

### Giriş yapamıyorum
- Şifrenin doğru olduğundan emin olun
- Kullanıcının `status = 'active'` olduğundan emin olun
- Database'de kullanıcının var olduğunu kontrol edin

### 403 Unauthorized hatası
- `is_admin` kolonunun `true` olduğunu kontrol edin
- Migration'ın çalıştığından emin olun: `php artisan migrate`

