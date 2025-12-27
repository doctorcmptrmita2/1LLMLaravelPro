# CodexFlow Dashboard

**Profesyonel AI API kullanım takip ve yönetim platformu**

CodexFlow, LiteLLM proxy ile entegre çalışan, gerçek zamanlı API kullanım analizi, maliyet takibi ve rate limit yönetimi sağlayan modern bir Laravel dashboard uygulamasıdır.

## 🚀 Özellikler

- ✅ **Real-time Usage Tracking** - API çağrılarını gerçek zamanlı takip
- ✅ **Cost Analytics** - Detaylı maliyet analizi ve trend grafikleri
- ✅ **Rate Limit Monitoring** - Günlük/aylık limit takibi ve uyarılar
- ✅ **Model Management** - AI model seçimi ve favoriler
- ✅ **API Key Management** - Güvenli API key yönetimi
- ✅ **Usage Reports** - Detaylı kullanım raporları ve CSV export
- ✅ **LiteLLM Integration** - LiteLLM proxy ile otomatik entegrasyon
- ✅ **Beautiful UI** - Modern dark theme, responsive tasarım

## 📋 Gereksinimler

- PHP 8.3+
- Composer
- Node.js 20+
- PostgreSQL veya SQLite
- Docker (opsiyonel, Easypanel deployment için)

## 🛠️ Kurulum

### 1. Repository'yi Klonlayın

```bash
git clone https://github.com/doctorcmptrmita2/1LLMLaravelPro.git
cd 1LLMLaravelPro/codexflow
```

### 2. Dependencies Yükleyin

```bash
composer install
npm install
```

### 3. Environment Yapılandırması

```bash
cp .env.example .env
php artisan key:generate
```

`.env` dosyasını düzenleyin:
```env
APP_NAME=CodexFlow
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# veya PostgreSQL için:
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=codexflow
# DB_USERNAME=codexflow_user
# DB_PASSWORD=your_password

# LiteLLM Integration
LITELLM_WEBHOOK_KEY=your_secure_webhook_key
LITELLM_PROXY_URL=https://proxyapison-litellmproxyv1.lc58dd.easypanel.host
```

### 4. Database Setup

```bash
php artisan migrate
php artisan storage:link
```

### 5. Assets Build

```bash
npm run build
```

### 6. Development Server

```bash
php artisan serve
```

Uygulama `http://localhost:8000` adresinde çalışacaktır.

## 🐳 Docker ile Çalıştırma

Detaylı bilgi için `README_DOCKER.md` dosyasına bakın.

```bash
docker-compose up -d
```

## 🚀 Easypanel Deployment

Easypanel'de deploy etmek için `EASYPANEL_DEPLOY.md` dosyasına bakın.

## 🔗 LiteLLM Entegrasyonu

LiteLLM proxy ile entegrasyon için `LITELLM_INTEGRATION.md` dosyasına bakın.

## 📁 Proje Yapısı

```
codexflow/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/    # API Controllers
│   │   └── Middleware/         # Custom Middleware
│   ├── Models/                 # Eloquent Models
│   └── Services/               # Business Logic
├── database/
│   └── migrations/             # Database Migrations
├── resources/
│   ├── views/                  # Blade Templates
│   ├── css/                    # Tailwind CSS
│   └── js/                     # JavaScript
├── routes/
│   ├── api.php                 # API Routes
│   └── web.php                 # Web Routes
├── docker/                     # Docker Configs
├── Dockerfile                  # Docker Image
└── docker-compose.yml          # Docker Compose
```

## 🔐 API Authentication

API authentication için Laravel Sanctum kullanılmaktadır.

### Register
```bash
POST /api/auth/register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

### Login
```bash
POST /api/auth/login
{
  "email": "john@example.com",
  "password": "password"
}
```

### Protected Endpoints
Tüm protected endpoint'ler için `Authorization: Bearer {token}` header'ı gereklidir.

## 📊 API Endpoints

- `GET /api/dashboard/stats` - Dashboard istatistikleri
- `GET /api/dashboard/usage` - Kullanım grafikleri
- `GET /api/usage/logs` - API logları
- `GET /api/usage/analytics` - Analytics verileri
- `POST /api/usage/export` - CSV export
- `GET /api/rate-limits` - Rate limit durumu
- `GET /api/models` - Mevcut modeller
- `GET /api/settings` - Kullanıcı ayarları

## 🧪 Testing

```bash
php artisan test
```

## 📝 License

MIT License

## 🤝 Contributing

Pull request'ler memnuniyetle karşılanır. Büyük değişiklikler için lütfen önce bir issue açın.

## 📞 Support

Sorularınız için GitHub Issues kullanabilirsiniz.

---

**CodexFlow ile AI API kullanımınızı profesyonelce yönetin! 🚀**
