# ✅ Easypanel Environment Variables - Doğru Ayarlar

## 🔴 YANLIŞ
```env
DB_HOST=postgresqlpro
```

## ✅ DOĞRU
```env
DB_HOST=codexflow-dashboard_postgresqlpro
```

## 📋 Tam Doğru Environment Variables

```env
APP_NAME=CodexFlow
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_ACTUAL_KEY_HERE
APP_URL=https://codexflow-dashboard-codexflow-dashboardpro.lc58dd.easypanel.host

DB_CONNECTION=pgsql
DB_HOST=codexflow-dashboard_postgresqlpro
DB_PORT=5432
DB_DATABASE=codexflow-dashboard
DB_USERNAME=postgres
DB_PASSWORD=8aac83dc2826870760e6

LITELLM_WEBHOOK_KEY=GÜÇLÜ_WEBHOOK_KEY_BURAYA
LITELLM_PROXY_URL=https://proxyapison-litellmproxyv1.lc58dd.easypanel.host

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_LEVEL=error
```

## ⚠️ Önemli Düzeltmeler

### 1. DB_HOST
- ❌ `DB_HOST=postgresqlpro`
- ✅ `DB_HOST=codexflow-dashboard_postgresqlpro`

**Neden?** Easypanel'de internal host name `codexflow-dashboard_postgresqlpro` formatında olur (project_name + service_name).

### 2. APP_KEY
- ❌ `APP_KEY=base64:... (php artisan key:generate --show ile oluşturun)`
- ✅ `APP_KEY=base64:GERÇEK_KEY_BURAYA`

**Nasıl oluşturulur?**
```bash
php artisan key:generate --show
```

### 3. APP_URL
- ❌ `APP_URL=https://dashboard.codexflow.dev`
- ✅ `APP_URL=https://codexflow-dashboard-codexflow-dashboardpro.lc58dd.easypanel.host`

**Neden?** Easypanel'in otomatik oluşturduğu domain'i kullanın.

### 4. LITELLM_WEBHOOK_KEY
- ❌ `LITELLM_WEBHOOK_KEY=GÜÇLÜ_WEBHOOK_KEY`
- ✅ `LITELLM_WEBHOOK_KEY=gerçek_güçlü_key_buraya`

**Nasıl oluşturulur?**
```bash
php artisan tinker
echo bin2hex(random_bytes(32));
```

## 🔍 Kontrol Listesi

- [ ] DB_HOST doğru: `codexflow-dashboard_postgresqlpro`
- [ ] APP_KEY gerçek key ile değiştirildi
- [ ] APP_URL Easypanel domain'i ile güncellendi
- [ ] LITELLM_WEBHOOK_KEY gerçek key ile değiştirildi
- [ ] Tüm credentials doğru

---

**Bu ayarlarla database bağlantısı çalışacak! 🚀**

