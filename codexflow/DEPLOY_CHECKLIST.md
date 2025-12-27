# 🚀 Deploy Checklist - CodexFlow

GitHub'a push etmeden önce kontrol edilmesi gerekenler:

## ✅ Pre-Deploy Checklist

### 1. Dosya Kontrolleri
- [x] `.env.example` dosyası var ve güncel
- [x] `.gitignore` doğru yapılandırılmış
- [x] `README.md` güncel ve bilgilendirici
- [x] `Dockerfile` hazır
- [x] `docker-compose.yml` hazır
- [x] `docker-entrypoint.sh` executable
- [x] Tüm sensitive dosyalar `.gitignore`'da

### 2. Environment Variables
- [x] `.env` dosyası `.gitignore`'da
- [x] `.env.example` tüm gerekli değişkenleri içeriyor
- [x] Production için gerekli değişkenler dokümante edilmiş

### 3. Database
- [x] Tüm migrations hazır
- [x] Migration dosyaları test edilmiş
- [x] Seeder'lar hazır (opsiyonel)

### 4. Security
- [x] API keys ve secrets `.env`'de
- [x] `.env` dosyası commit edilmemiş
- [x] Webhook key güvenli
- [x] CORS ayarları doğru

### 5. Code Quality
- [x] Linter hataları yok
- [x] Syntax hataları yok
- [x] Unused imports temizlenmiş
- [x] Debug kodları kaldırılmış

### 6. Documentation
- [x] `README.md` güncel
- [x] `EASYPANEL_DEPLOY.md` hazır
- [x] `LITELLM_INTEGRATION.md` hazır
- [x] `README_DOCKER.md` hazır

## 📦 GitHub'a Push

### 1. Git Status Kontrolü
```bash
git status
```

### 2. Değişiklikleri Ekleyin
```bash
git add .
```

### 3. Commit
```bash
git commit -m "feat: CodexFlow dashboard - production ready

- Laravel 12 + Livewire 3 + Sanctum
- Docker & Easypanel deployment ready
- LiteLLM proxy integration
- Real-time analytics & cost tracking
- Rate limit management
- Professional UI with Tailwind CSS"
```

### 4. Push
```bash
git push origin main
```

## 🚀 Easypanel Deployment

### 1. Repository Bağla
- GitHub repository URL'ini Easypanel'e ekle
- Branch: `main`

### 2. Environment Variables
Easypanel'de şu environment variables'ları ekle:
```env
APP_NAME=CodexFlow
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:... (php artisan key:generate --show)
APP_URL=https://dashboard.codexflow.dev

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=codexflow
DB_USERNAME=codexflow_user
DB_PASSWORD=secure_password

LITELLM_WEBHOOK_KEY=your_secure_webhook_key
LITELLM_PROXY_URL=https://proxyapison-litellmproxyv1.lc58dd.easypanel.host
```

### 3. Database Oluştur
- Easypanel'de PostgreSQL database oluştur
- Database bilgilerini environment variables'a ekle

### 4. Deploy
- Deploy butonuna tıkla
- Build loglarını takip et

### 5. Post-Deploy
Terminal'den çalıştır:
```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## 🔍 Post-Deploy Kontrolleri

- [ ] Uygulama erişilebilir
- [ ] Database bağlantısı çalışıyor
- [ ] API endpoints çalışıyor
- [ ] Webhook endpoint çalışıyor
- [ ] Dashboard görüntüleniyor
- [ ] Logs kaydediliyor
- [ ] Rate limits çalışıyor

## 🐛 Troubleshooting

### Build Hatası
- Dockerfile'ı kontrol et
- Environment variables'ları kontrol et
- Logs'u incele

### Database Hatası
- Database container çalışıyor mu?
- Connection string doğru mu?
- Migrations çalıştı mı?

### Webhook Çalışmıyor
- `LITELLM_WEBHOOK_KEY` doğru mu?
- LiteLLM proxy'de webhook URL doğru mu?
- Laravel logs'u kontrol et

---

**Deploy başarılı! 🎉**

