# 🔐 Admin Panel Kurulumu

## Özellikler

- ✅ Kullanıcı yönetimi
- ✅ API key atama ve güncelleme
- ✅ Kullanıcı durumu yönetimi (active/suspended)
- ✅ Admin yetkisi verme
- ✅ Kullanıcı istatistikleri

## Kurulum Adımları

### 1. Migration Çalıştır

```bash
php artisan migrate
```

### 2. İlk Admin Kullanıcısı Oluştur

**Seçenek 1: Tinker ile**
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

**Seçenek 2: SQL ile**
```sql
UPDATE users SET is_admin = 1 WHERE email = 'doctor.cmptr.mita2@gmail.com';
```

**Seçenek 3: Yeni Admin Kullanıcısı**
```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@codexflow.dev',
    'password' => \Hash::make('güçlü_şifre'),
    'api_key' => 'cf_' . bin2hex(random_bytes(32)),
    'plan' => 'agency',
    'status' => 'active',
    'is_admin' => true,
]);
```

## Kullanım

### Admin Paneline Erişim

1. Admin yetkisi olan bir hesapla giriş yapın
2. Dashboard'da **"Admin Panel"** linki görünecek
3. Veya direkt: `/admin`

### API Key Atama

1. Admin Panel'e gidin
2. "Assign API Key to User" formunu kullanın:
   - **Email:** `doctor.cmptr.mita2@gmail.com`
   - **API Key:** `sk-7Cif43XHbgNSMtSIaul_Xw`
3. "Assign API Key" butonuna tıklayın

### Kullanıcı Yönetimi

- **View:** Kullanıcı detaylarını görüntüle
- **Update:** Kullanıcı bilgilerini güncelle
- **Suspend/Activate:** Kullanıcıyı askıya al veya aktif et
- **API Key Update:** Kullanıcının API key'ini güncelle

## Route'lar

- `GET /admin` - Admin panel ana sayfa
- `GET /admin/users/{user}` - Kullanıcı detayları
- `POST /admin/users/assign-api-key` - API key atama
- `POST /admin/users/{user}/api-key` - API key güncelleme
- `POST /admin/users/{user}/update` - Kullanıcı güncelleme
- `POST /admin/users/{user}/suspend` - Kullanıcıyı askıya al
- `POST /admin/users/{user}/activate` - Kullanıcıyı aktif et

## Güvenlik

- Admin route'ları `admin` middleware ile korunur
- Sadece `is_admin = true` olan kullanıcılar erişebilir
- CSRF koruması aktif

## Notlar

- Admin yetkisi verilen kullanıcılar dashboard'da "Admin Panel" linkini görür
- API key'ler unique olmalıdır
- Email adresi unique olmalıdır

