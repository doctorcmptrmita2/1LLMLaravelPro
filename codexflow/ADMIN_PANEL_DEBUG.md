# 🔍 Admin Panel Açılmıyor - Debug Rehberi

## Sorun
- ✅ Dashboard açılıyor: `/dashboard`
- ❌ Admin panel açılmıyor: `/admin` → Login'e yönlendiriyor

## Olası Nedenler

### 1. Migration Çalıştırılmamış
`is_admin` kolonu database'de yok.

**Kontrol:**
```bash
php artisan tinker
```

```php
$user = \App\Models\User::first();
var_dump(isset($user->is_admin));
// Eğer false dönerse, kolon yok
```

**Çözüm:**
```bash
php artisan migrate
```

### 2. Kullanıcının Admin Yetkisi Yok
Kullanıcı login olmuş ama `is_admin = false`.

**Kontrol:**
```bash
php artisan tinker
```

```php
$user = \App\Models\User::where('email', 'admin@codexflow.dev')->first();
if ($user) {
    echo "is_admin: " . ($user->is_admin ? 'true' : 'false');
} else {
    echo "Kullanıcı bulunamadı!";
}
```

**Çözüm:**
```php
$user = \App\Models\User::where('email', 'admin@codexflow.dev')->first();
if ($user) {
    $user->update(['is_admin' => true]);
    echo "Admin yetkisi verildi!";
}
```

### 3. Session Sorunu
Login olmuş ama session kaybolmuş.

**Kontrol:**
- Dashboard'a giriş yapabiliyor musunuz?
- Logout yapıp tekrar login olun

## 🚀 Hızlı Çözüm

### Adım 1: Migration Çalıştır
```bash
php artisan migrate
```

### Adım 2: Admin Kullanıcısı Oluştur veya Yetki Ver
```bash
php artisan tinker
```

```php
// Mevcut kullanıcıya admin yetkisi ver
$user = \App\Models\User::where('email', 'admin@codexflow.dev')->first();
if ($user) {
    $user->update(['is_admin' => true]);
    echo "Admin yetkisi verildi!";
} else {
    // Yeni admin kullanıcısı oluştur
    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@codexflow.dev',
        'password' => \Hash::make('Admin123!'),
        'api_key' => 'cf_' . bin2hex(random_bytes(32)),
        'plan' => 'agency',
        'status' => 'active',
        'is_admin' => true,
    ]);
    echo "Admin kullanıcısı oluşturuldu!";
}
```

### Adım 3: Cache Temizle
```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
```

### Adım 4: Test
1. Logout yapın
2. Login olun: `admin@codexflow.dev` / `Admin123!`
3. `/admin` adresine gidin

## 🔍 Detaylı Debug

### Route Kontrolü
```bash
php artisan route:list | grep admin
```

Admin route'larının kayıtlı olduğunu kontrol edin.

### Middleware Kontrolü
```bash
php artisan route:list --path=admin
```

### Log Kontrolü
```bash
tail -n 50 storage/logs/laravel.log | grep -i admin
```

## ✅ Başarı Kriterleri

- ✅ Migration çalıştı: `is_admin` kolonu var
- ✅ Admin kullanıcısı var ve `is_admin = true`
- ✅ Login başarılı
- ✅ `/admin` route'u çalışıyor
- ✅ Admin panel görünüyor

---

**En yaygın sorun: Migration çalıştırılmamış veya kullanıcının admin yetkisi yok!**

