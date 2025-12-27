# Docker Deployment - CodexFlow

## 🐳 Docker ile Çalıştırma

### Gereksinimler
- Docker
- Docker Compose

### Hızlı Başlangıç

1. **Environment dosyasını oluşturun:**
```bash
cp .env.example .env
```

2. **.env dosyasını düzenleyin:**
```env
APP_NAME=CodexFlow
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_URL=http://localhost:8001

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=codexflow
DB_USERNAME=codexflow_user
DB_PASSWORD=secure_password
```

3. **APP_KEY oluşturun:**
```bash
php artisan key:generate --show
```

4. **Docker Compose ile başlatın:**
```bash
docker-compose up -d
```

5. **Migrations çalıştırın:**
```bash
docker-compose exec app php artisan migrate --force
```

6. **Storage link oluşturun:**
```bash
docker-compose exec app php artisan storage:link
```

7. **Cache optimize edin:**
```bash
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
docker-compose exec app php artisan optimize
```

### Uygulamaya Erişim

- **Web:** http://localhost:8001
- **Database:** localhost:5432

### Komutlar

**Logs görüntüleme:**
```bash
docker-compose logs -f app
```

**Container'a giriş:**
```bash
docker-compose exec app bash
```

**Container'ları durdurma:**
```bash
docker-compose down
```

**Container'ları yeniden başlatma:**
```bash
docker-compose restart
```

**Tüm verileri silme (dikkatli!):**
```bash
docker-compose down -v
```

## 🔧 Easypanel Deployment

Detaylı bilgi için `EASYPANEL_DEPLOY.md` dosyasına bakın.

