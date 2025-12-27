# Easypanel Deployment Kılavuzu - CodexFlow

## 🚀 Easypanel'de Deploy Adımları

### 1. Yeni App Oluştur

1. Easypanel dashboard'a giriş yapın
2. **New App** butonuna tıklayın
3. **Docker** seçeneğini seçin
4. App bilgilerini girin:
   - **Name:** `codexflow-dashboard`
   - **Port:** `8001`
   - **Domain:** `dashboard.codexflow.dev` (veya kendi domain'iniz)

### 2. Git Repository Bağla

- Repository URL'ini girin
- Branch: `main` veya `master`
- Build Command: (boş bırakın, Dockerfile kullanılacak)

### 3. Environment Variables

Easypanel'de **Environment Variables** sekmesine gidin ve şunları ekleyin:

```env
APP_NAME=CodexFlow
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_URL=https://dashboard.codexflow.dev

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=codexflow
DB_USERNAME=codexflow_user
DB_PASSWORD=GÜÇLÜ_ŞİFRE_BURAYA

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_LEVEL=error
```

**ÖNEMLİ:** `APP_KEY` değerini oluşturmak için:
```bash
php artisan key:generate --show
```

### 4. Database (PostgreSQL) Oluştur

1. Easypanel'de **New Database** oluşturun
2. **PostgreSQL** seçin
3. Database bilgilerini environment variables'a ekleyin:
   - `DB_HOST`: Database container adı (örn: `postgres`)
   - `DB_DATABASE`: Database adı
   - `DB_USERNAME`: Database kullanıcı adı
   - `DB_PASSWORD`: Database şifresi

### 5. Docker Compose Yapılandırması

Easypanel'de **Docker Compose** sekmesine gidin ve `docker-compose.yml` dosyasını kullanın.

**Not:** Easypanel otomatik olarak `docker-compose.yml` dosyasını algılayacaktır.

### 6. Deploy

1. **Deploy** butonuna tıklayın
2. Build işlemi tamamlanana kadar bekleyin (2-5 dakika)
3. Logs sekmesinden build ve deploy sürecini takip edin

### 7. İlk Kurulum (Post-Deploy)

Deploy tamamlandıktan sonra, **Terminal** sekmesinden şu komutları çalıştırın:

```bash
# Migrations çalıştır
php artisan migrate --force

# Storage link oluştur
php artisan storage:link

# Cache temizle ve optimize et
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 8. Test Kullanıcısı Oluştur (Opsiyonel)

```bash
php artisan tinker
```

Tinker içinde:
```php
$user = \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@codexflow.dev',
    'password' => bcrypt('secure_password'),
    'api_key' => 'cf_' . bin2hex(random_bytes(32)),
    'plan' => 'agency',
    'status' => 'active'
]);
```

## 🔧 Troubleshooting

### Database Bağlantı Hatası

- Database container'ın çalıştığından emin olun
- Environment variables'da `DB_HOST` değerinin doğru olduğunu kontrol edin
- Database credentials'ların doğru olduğunu kontrol edin

### Permission Hataları

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 500 Error

- Logs sekmesinden hata mesajlarını kontrol edin
- `APP_DEBUG=true` yaparak detaylı hata mesajlarını görebilirsiniz (production'da `false` yapın)

### Assets Yüklenmiyor

```bash
npm install
npm run build
php artisan optimize:clear
```

## 📊 Health Check

Easypanel'de health check endpoint'i:
- URL: `/up`
- Method: GET
- Expected: 200 OK

## 🔐 Güvenlik

1. **APP_DEBUG=false** production'da mutlaka false olmalı
2. **APP_KEY** güçlü ve unique olmalı
3. **Database password** güçlü olmalı
4. **API keys** güvenli şekilde saklanmalı

## 📈 Monitoring

- Easypanel dashboard'dan resource kullanımını takip edin
- Logs sekmesinden application loglarını görüntüleyin
- Database connection pool'u izleyin

## 🔄 Update/Deploy

Yeni bir deploy yapmak için:
1. Git repository'ye push yapın
2. Easypanel'de **Redeploy** butonuna tıklayın
3. Build ve deploy sürecini takip edin

---

**Başarılar! 🚀**

