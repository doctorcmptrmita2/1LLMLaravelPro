# Laravel Dashboard App - Prompt & Specification

**Amaç:** CodexFlow API kullanımını takip eden profesyonel bir Laravel dashboard oluştur

---

## 📋 Prompt (Claude/Cursor'a Yapıştır)

```
Aşağıdaki özellikleri olan bir Laravel 11 dashboard uygulaması oluştur:

## Genel Gereksinimler
- Laravel 11 + Livewire 3 (reactive components)
- Tailwind CSS (dark theme, profesyonel)
- SQLite veya PostgreSQL database
- API authentication (Bearer token)
- Real-time updates (WebSocket opsiyonel)

## Database Schema

### Users Table
- id, name, email, password
- api_key (unique)
- plan (starter, pro, agency)
- status (active, suspended)
- created_at, updated_at

### API Usage Logs Table
- id, user_id, model, input_tokens, output_tokens
- total_cost, response_time_ms
- status (success, error, rate_limited)
- error_message (nullable)
- created_at

### Models Table
- id, name, model_id (anthropic/claude-haiku-4-5-20251001)
- cost_per_1k_tokens, availability
- created_at

### Rate Limits Table
- id, user_id, period (daily, monthly)
- limit_tokens, used_tokens
- limit_requests, used_requests
- reset_at
- created_at

## Features

### 1. Dashboard Home
- Kullanıcı profili (name, email, plan, api_key)
- Bugünün istatistikleri:
  * Toplam API çağrısı
  * Toplam token kullanımı
  * Toplam maliyet
  * Ortalama response time
- Ay sonu kalanı (tokens, requests)
- Uyarılar (rate limit yaklaşıyor, vb.)

### 2. Usage Analytics
- Grafik: Günlük token kullanımı (Chart.js)
- Grafik: Model dağılımı (pie chart)
- Grafik: Maliyet trendi (line chart)
- Tablo: Son 50 API çağrısı
  * Model, Input tokens, Output tokens, Cost, Response time, Status
  * Filtreleme: Model, Tarih aralığı, Status
  * Sorting: Tarih, Cost, Response time

### 3. API Logs
- Detaylı log tablosu
- Arama: Model, Status, Tarih
- Pagination (50 per page)
- Export CSV
- Error details modal

### 4. Rate Limits
- Günlük limit durumu (progress bar)
- Aylık limit durumu (progress bar)
- Kalan tokens/requests
- Reset tarihleri
- Limit artırma talebi formu

### 5. Models
- Mevcut modeller listesi
- Model detayları: cost, availability, description
- Model seçimi (favoriler)

### 6. Settings
- API key yönetimi (regenerate, copy)
- Plan bilgisi
- Billing history (opsiyonel)
- Notification preferences

### 7. Admin Panel (Opsiyonel)
- Tüm kullanıcılar listesi
- Kullanıcı detayları
- Usage override
- Suspend/activate user

## API Endpoints (Backend)

### Authentication
- POST /api/auth/register
- POST /api/auth/login
- POST /api/auth/logout
- GET /api/auth/me

### Dashboard
- GET /api/dashboard/stats (bugünün istatistikleri)
- GET /api/dashboard/usage (grafik verileri)
- GET /api/dashboard/logs (API logs)

### Usage
- GET /api/usage/logs (paginated)
- GET /api/usage/analytics (grafik verileri)
- POST /api/usage/export (CSV)

### Rate Limits
- GET /api/rate-limits
- POST /api/rate-limits/request-increase

### Models
- GET /api/models
- POST /api/models/favorite

### Settings
- GET /api/settings
- POST /api/settings/api-key/regenerate
- POST /api/settings/update

## UI/UX

### Design
- Dark theme (profesyonel)
- Responsive (mobile-first)
- Smooth animations
- Consistent spacing

### Colors
- Primary: #6D5CFF (purple)
- Accent: #22D3EE (cyan)
- Success: #3EE48B (green)
- Warning: #FFCC66 (yellow)
- Error: #FF6B6B (red)
- Background: #070A12 (dark)
- Surface: #0E1330 (lighter dark)

### Components
- Navbar (logo, user menu, logout)
- Sidebar (navigation)
- Cards (stats, models)
- Charts (Chart.js)
- Tables (sortable, filterable)
- Modals (error details, confirmations)
- Forms (settings, requests)
- Progress bars (rate limits)
- Alerts (warnings, errors)

## Security
- CSRF protection
- Rate limiting (60 requests/minute)
- Input validation
- SQL injection prevention
- XSS protection
- API key hashing

## Performance
- Database indexing (user_id, created_at)
- Query optimization (eager loading)
- Caching (Redis opsiyonel)
- Pagination
- Lazy loading (images, charts)

## Testing
- Unit tests (models, services)
- Feature tests (API endpoints)
- Browser tests (UI interactions)

## Deployment
- Docker support
- Environment variables
- Database migrations
- Seeding (test data)

## File Structure
```
laravel-dashboard/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── UsageController.php
│   │   │   ├── RateLimitController.php
│   │   │   ├── ModelController.php
│   │   │   └── SettingsController.php
│   │   ├── Requests/
│   │   └── Resources/
│   ├── Models/
│   │   ├── User.php
│   │   ├── ApiLog.php
│   │   ├── Model.php
│   │   └── RateLimit.php
│   ├── Services/
│   │   ├── UsageService.php
│   │   ├── RateLimitService.php
│   │   └── AnalyticsService.php
│   └── Jobs/
│       └── LogApiUsage.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── dashboard/
│   │   ├── usage/
│   │   ├── settings/
│   │   └── auth/
│   └── css/
│       └── app.css (Tailwind)
├── routes/
│   ├── api.php
│   ├── web.php
│   └── auth.php
├── tests/
│   ├── Unit/
│   └── Feature/
├── docker-compose.yml
├── Dockerfile
└── .env.example
```

## Başlangıç Adımları
1. Laravel 11 projesi oluştur
2. Database schema'sını migrate et
3. Authentication setup (Laravel Sanctum)
4. API endpoints'leri oluştur
5. Frontend views'leri oluştur (Blade + Livewire)
6. Charts ve analytics'i entegre et
7. Testing'i yaz
8. Docker setup'ı oluştur
9. Deployment kılavuzunu yaz

## Notlar
- PSR-12 standartlarına uy
- Clean code principles
- DRY (Don't Repeat Yourself)
- SOLID principles
- Comprehensive error handling
- Logging (Laravel Log)
- Monitoring (opsiyonel)
```

---

## 🎯 Özet

Bu dashboard şunları sağlayacak:

### Kullanıcı Perspektifi
- ✅ API kullanımını gerçek zamanlı takip
- ✅ Maliyet analizi
- ✅ Rate limit durumu
- ✅ Model seçimi ve favoriler
- ✅ API key yönetimi
- ✅ Kullanım raporları

### İşletme Perspektifi
- ✅ Kullanıcı davranışı analizi
- ✅ Maliyet takibi
- ✅ Rate limit yönetimi
- ✅ Churn prevention (uyarılar)
- ✅ Admin panel (user management)

---

## 📊 Teknik Stack

```
Frontend:
- Laravel Blade (template engine)
- Livewire 3 (reactive components)
- Tailwind CSS (styling)
- Chart.js (grafikleri)
- Alpine.js (interactivity)

Backend:
- Laravel 11
- Laravel Sanctum (API auth)
- Eloquent ORM
- Queue (background jobs)
- Cache (Redis opsiyonel)

Database:
- PostgreSQL (production)
- SQLite (development)

DevOps:
- Docker
- Docker Compose
- GitHub Actions (CI/CD)
```

---

## 🚀 Deployment

```
Easypanel'de:
1. Yeni Laravel app oluştur
2. Database (PostgreSQL) ekle
3. Redis cache (opsiyonel) ekle
4. Environment variables set et
5. Migrations çalıştır
6. Deploy et
```

---

## 📈 Beklenen Sonuç

Profesyonel, hızlı, güvenli bir dashboard:
- ✅ Real-time usage tracking
- ✅ Beautiful UI/UX
- ✅ Comprehensive analytics
- ✅ Secure API
- ✅ Scalable architecture

---

## 💡 Bonus Features (Opsiyonel)

- Webhook notifications (usage alerts)
- Email reports (weekly/monthly)
- API documentation (Swagger)
- Team management (multi-user)
- Custom rate limits
- Usage forecasting (ML)
- Cost optimization suggestions

---

**Bu prompt'u Claude/Cursor'a yapıştırarak başlayabilirsiniz!**

