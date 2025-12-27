# Laravel Dashboard - Easypanel Setup Kılavuzu

**Amaç:** CodexFlow API kullanımını takip eden Laravel dashboard'u Easypanel'de deploy etmek

---

## 🎯 Mimari

```
┌─────────────────────────────────────────────────────────┐
│                    Easypanel                             │
├─────────────────────────────────────────────────────────┤
│                                                           │
│  ┌──────────────────┐  ┌──────────────────┐             │
│  │  Haiku Proxy     │  │  Laravel         │             │
│  │  (API)           │  │  Dashboard       │             │
│  │  Port: 8000      │  │  Port: 8001      │             │
│  └──────────────────┘  └──────────────────┘             │
│         ↓                      ↓                          │
│  ┌──────────────────────────────────────┐               │
│  │  PostgreSQL Database                 │               │
│  │  (Shared)                            │               │
│  └──────────────────────────────────────┘               │
│         ↓                                                 │
│  ┌──────────────────────────────────────┐               │
│  │  Redis Cache (Opsiyonel)             │               │
│  └──────────────────────────────────────┘               │
│                                                           │
└─────────────────────────────────────────────────────────┘
```

---

## 📋 Adım 1: Laravel Projesi Oluştur

### Lokal Ortamda

```bash
# Laravel 11 projesi oluştur
composer create-project laravel/laravel laravel-dashboard

cd laravel-dashboard

# Gerekli paketleri yükle
composer require livewire/livewire
composer require laravel/sanctum
composer require laravel/tinker

# Frontend paketleri
npm install
npm install chart.js
npm install alpinejs
```

---

## 🗄️ Adım 2: Database Schema

### Migrations Oluştur

```bash
# Models ve migrations
php artisan make:model User -m
php artisan make:model ApiLog -m
php artisan make:model Model -m
php artisan make:model RateLimit -m
```

### Migration Files

#### users migration
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('api_key')->unique();
    $table->enum('plan', ['starter', 'pro', 'agency'])->default('starter');
    $table->enum('status', ['active', 'suspended'])->default('active');
    $table->timestamps();
});
```

#### api_logs migration
```php
Schema::create('api_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('model');
    $table->integer('input_tokens');
    $table->integer('output_tokens');
    $table->decimal('total_cost', 10, 6);
    $table->integer('response_time_ms');
    $table->enum('status', ['success', 'error', 'rate_limited'])->default('success');
    $table->text('error_message')->nullable();
    $table->timestamps();
    
    $table->index(['user_id', 'created_at']);
});
```

#### models migration
```php
Schema::create('models', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('model_id');
    $table->decimal('cost_per_1k_tokens', 10, 6);
    $table->boolean('availability')->default(true);
    $table->timestamps();
});
```

#### rate_limits migration
```php
Schema::create('rate_limits', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->enum('period', ['daily', 'monthly']);
    $table->integer('limit_tokens');
    $table->integer('used_tokens')->default(0);
    $table->integer('limit_requests');
    $table->integer('used_requests')->default(0);
    $table->timestamp('reset_at');
    $table->timestamps();
    
    $table->unique(['user_id', 'period']);
});
```

---

## 🔐 Adım 3: Authentication Setup

### Laravel Sanctum

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### User Model
```php
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'api_key',
        'plan',
        'status',
    ];

    protected $hidden = [
        'password',
        'api_key',
    ];

    public function apiLogs()
    {
        return $this->hasMany(ApiLog::class);
    }

    public function rateLimits()
    {
        return $this->hasMany(RateLimit::class);
    }
}
```

---

## 🛣️ Adım 4: API Routes

### routes/api.php

```php
Route::middleware('auth:sanctum')->group(function () {
    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('/dashboard/usage', [DashboardController::class, 'usage']);
    
    // Usage
    Route::get('/usage/logs', [UsageController::class, 'logs']);
    Route::get('/usage/analytics', [UsageController::class, 'analytics']);
    Route::post('/usage/export', [UsageController::class, 'export']);
    
    // Rate Limits
    Route::get('/rate-limits', [RateLimitController::class, 'index']);
    Route::post('/rate-limits/request-increase', [RateLimitController::class, 'requestIncrease']);
    
    // Models
    Route::get('/models', [ModelController::class, 'index']);
    Route::post('/models/favorite', [ModelController::class, 'favorite']);
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::post('/settings/api-key/regenerate', [SettingsController::class, 'regenerateApiKey']);
    Route::post('/settings/update', [SettingsController::class, 'update']);
});
```

---

## 🎨 Adım 5: Frontend Views

### resources/views/dashboard.blade.php

```blade
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-surface rounded-lg p-6">
                    <h3 class="text-muted text-sm font-medium">API Calls Today</h3>
                    <p class="text-3xl font-bold text-text mt-2">{{ $stats['api_calls'] }}</p>
                </div>
                
                <div class="bg-surface rounded-lg p-6">
                    <h3 class="text-muted text-sm font-medium">Tokens Used</h3>
                    <p class="text-3xl font-bold text-text mt-2">{{ number_format($stats['tokens_used']) }}</p>
                </div>
                
                <div class="bg-surface rounded-lg p-6">
                    <h3 class="text-muted text-sm font-medium">Total Cost</h3>
                    <p class="text-3xl font-bold text-text mt-2">${{ number_format($stats['total_cost'], 2) }}</p>
                </div>
                
                <div class="bg-surface rounded-lg p-6">
                    <h3 class="text-muted text-sm font-medium">Avg Response Time</h3>
                    <p class="text-3xl font-bold text-text mt-2">{{ $stats['avg_response_time'] }}ms</p>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Token Usage Chart -->
                <div class="bg-surface rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-text mb-4">Daily Token Usage</h3>
                    <canvas id="tokenChart"></canvas>
                </div>

                <!-- Model Distribution -->
                <div class="bg-surface rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-text mb-4">Model Distribution</h3>
                    <canvas id="modelChart"></canvas>
                </div>
            </div>

            <!-- Rate Limits -->
            <div class="bg-surface rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-text mb-4">Rate Limits</h3>
                
                <div class="space-y-4">
                    <!-- Daily Limit -->
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-muted">Daily Tokens</span>
                            <span class="text-text">{{ $rateLimits['daily']['used'] }} / {{ $rateLimits['daily']['limit'] }}</span>
                        </div>
                        <div class="w-full bg-surface2 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full" style="width: {{ ($rateLimits['daily']['used'] / $rateLimits['daily']['limit']) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Monthly Limit -->
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-muted">Monthly Tokens</span>
                            <span class="text-text">{{ $rateLimits['monthly']['used'] }} / {{ $rateLimits['monthly']['limit'] }}</span>
                        </div>
                        <div class="w-full bg-surface2 rounded-full h-2">
                            <div class="bg-accent h-2 rounded-full" style="width: {{ ($rateLimits['monthly']['used'] / $rateLimits['monthly']['limit']) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Logs -->
            <div class="bg-surface rounded-lg p-6">
                <h3 class="text-lg font-semibold text-text mb-4">Recent API Calls</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-border">
                                <th class="text-left py-3 px-4 text-muted text-sm">Model</th>
                                <th class="text-left py-3 px-4 text-muted text-sm">Input Tokens</th>
                                <th class="text-left py-3 px-4 text-muted text-sm">Output Tokens</th>
                                <th class="text-left py-3 px-4 text-muted text-sm">Cost</th>
                                <th class="text-left py-3 px-4 text-muted text-sm">Response Time</th>
                                <th class="text-left py-3 px-4 text-muted text-sm">Status</th>
                                <th class="text-left py-3 px-4 text-muted text-sm">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr class="border-b border-border hover:bg-surface2">
                                <td class="py-3 px-4 text-text">{{ $log->model }}</td>
                                <td class="py-3 px-4 text-text">{{ number_format($log->input_tokens) }}</td>
                                <td class="py-3 px-4 text-text">{{ number_format($log->output_tokens) }}</td>
                                <td class="py-3 px-4 text-text">${{ number_format($log->total_cost, 4) }}</td>
                                <td class="py-3 px-4 text-text">{{ $log->response_time_ms }}ms</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        @if($log->status === 'success') bg-success/20 text-success
                                        @elseif($log->status === 'error') bg-error/20 text-error
                                        @else bg-warning/20 text-warning
                                        @endif">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-muted text-sm">{{ $log->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Token Usage Chart
        const tokenCtx = document.getElementById('tokenChart').getContext('2d');
        new Chart(tokenCtx, {
            type: 'line',
            data: {
                labels: @json($chartData['dates']),
                datasets: [{
                    label: 'Tokens Used',
                    data: @json($chartData['tokens']),
                    borderColor: '#6D5CFF',
                    backgroundColor: 'rgba(109, 92, 255, 0.1)',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });

        // Model Distribution Chart
        const modelCtx = document.getElementById('modelChart').getContext('2d');
        new Chart(modelCtx, {
            type: 'doughnut',
            data: {
                labels: @json($chartData['models']),
                datasets: [{
                    data: @json($chartData['modelCounts']),
                    backgroundColor: [
                        '#6D5CFF',
                        '#22D3EE',
                        '#3EE48B',
                        '#FFCC66',
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
```

---

## 🐳 Adım 6: Docker Setup

### Dockerfile

```dockerfile
FROM php:8.3-fpm

# Dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
```

### docker-compose.yml (Easypanel'de)

```yaml
version: '3.8'

services:
  laravel:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: laravel_dashboard
    restart: unless-stopped
    working_dir: /var/www/html
    environment:
      APP_ENV: production
      APP_DEBUG: false
      APP_KEY: ${APP_KEY}
      DB_CONNECTION: pgsql
      DB_HOST: postgres
      DB_PORT: 5432
      DB_DATABASE: ${DB_DATABASE}
      DB_USERNAME: ${DB_USERNAME}
      DB_PASSWORD: ${DB_PASSWORD}
    volumes:
      - ./:/var/www/html
    ports:
      - "8001:9000"
    networks:
      - litellm_network
    depends_on:
      - postgres

  postgres:
    image: postgres:15-alpine
    container_name: laravel_postgres
    restart: unless-stopped
    environment:
      POSTGRES_DB: ${DB_DATABASE}
      POSTGRES_USER: ${DB_USERNAME}
      POSTGRES_PASSWORD: ${DB_PASSWORD}
    volumes:
      - postgres_data:/var/lib/postgresql/data
    networks:
      - litellm_network

  nginx:
    image: nginx:alpine
    container_name: laravel_nginx
    restart: unless-stopped
    ports:
      - "8001:80"
    volumes:
      - ./:/var/www/html
      - ./nginx.conf:/etc/nginx/conf.d/default.conf
    networks:
      - litellm_network
    depends_on:
      - laravel

networks:
  litellm_network:
    driver: bridge

volumes:
  postgres_data:
```

---

## 🚀 Adım 7: Easypanel'de Deploy

### 1. Yeni App Oluştur
- **Name:** `laravel-dashboard`
- **Type:** Docker
- **Port:** 8001

### 2. Environment Variables Set Et
```
APP_NAME=CodexFlow
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...
APP_URL=https://dashboard.codexflow.dev

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=laravel_dashboard
DB_USERNAME=laravel_user
DB_PASSWORD=secure_password

REDIS_HOST=redis
REDIS_PASSWORD=redis_password
```

### 3. Database Migrate Et
```bash
php artisan migrate --force
php artisan db:seed
```

### 4. Deploy Et
- Deploy butonuna bas
- 2-3 dakika bekle

### 5. Domain Ayarla
```
Domain: dashboard.codexflow.dev
Port: 8001
```

---

## 📊 Adım 8: Haiku Proxy ile Entegrasyon

### Haiku Proxy'de API Log Gönderme

`litellm-haiku-proxy.py`'ye ekle:

```python
import httpx

async def log_api_usage(user_id, model, input_tokens, output_tokens, cost, response_time, status):
    """Log API usage to Laravel dashboard"""
    try:
        async with httpx.AsyncClient() as client:
            await client.post(
                "http://laravel:8001/api/usage/log",
                json={
                    "user_id": user_id,
                    "model": model,
                    "input_tokens": input_tokens,
                    "output_tokens": output_tokens,
                    "total_cost": cost,
                    "response_time_ms": response_time,
                    "status": status,
                },
                headers={"Authorization": f"Bearer {LITELLM_MASTER_KEY}"}
            )
    except Exception as e:
        logger.error(f"Failed to log API usage: {str(e)}")
```

---

## ✅ Kontrol Listesi

- [ ] Laravel 11 projesi oluştur
- [ ] Database migrations oluştur
- [ ] Authentication setup (Sanctum)
- [ ] API routes oluştur
- [ ] Controllers oluştur
- [ ] Views oluştur (Blade)
- [ ] Charts entegre et (Chart.js)
- [ ] Docker setup oluştur
- [ ] Easypanel'de app oluştur
- [ ] Environment variables set et
- [ ] Database migrate et
- [ ] Deploy et
- [ ] Domain ayarla
- [ ] Test et

---

## 🧪 Test

```bash
# Health check
curl https://dashboard.codexflow.dev/health

# Login
curl -X POST https://dashboard.codexflow.dev/api/login \
  -d "email=user@example.com&password=password"

# Dashboard stats
curl -H "Authorization: Bearer TOKEN" \
  https://dashboard.codexflow.dev/api/dashboard/stats
```

---

## 📈 Beklenen Sonuç

Profesyonel Laravel dashboard:
- ✅ Real-time usage tracking
- ✅ Beautiful UI (Tailwind CSS)
- ✅ Comprehensive analytics
- ✅ Secure API (Sanctum)
- ✅ Scalable architecture

---

**Dashboard deployment hazır! 🚀**

