# 🔧 Easypanel Service Not Reachable Düzeltmesi

## Sorun
"Service is not reachable" hatası alınıyor.

## ✅ Kontrol Edilmesi Gerekenler

### 1. Container Durumu
Easypanel'de **Logs** sekmesine gidin ve container'ın çalışıp çalışmadığını kontrol edin.

### 2. Port Mapping
Easypanel'de app ayarlarında:
- **Port:** `8001` (veya belirlediğiniz port)
- **Internal Port:** `9000` (PHP-FPM portu)

**ÖNEMLİ:** PHP-FPM container'ı 9000 portunda çalışır, ama web server (Nginx) 80 portunda olmalı.

### 3. Nginx Servisi Eksik
Easypanel'de **2 servis** olmalı:

#### Servis 1: PHP-FPM (app)
- **Type:** Docker
- **Port:** `9000` (internal)
- **Dockerfile:** Mevcut Dockerfile

#### Servis 2: Nginx (web server) - EKLEMELİSİNİZ
- **Type:** Docker
- **Image:** `nginx:alpine`
- **Port:** `8001` (external) → `80` (internal)
- **Volumes:**
  - `/var/www/html` → app container'ın volume'u
  - `docker/nginx/default.conf` → `/etc/nginx/conf.d/default.conf`

### 4. Alternatif: PHP Built-in Server
Eğer Nginx eklemek istemiyorsanız, Dockerfile'ı PHP built-in server kullanacak şekilde değiştirin.

### 5. Entrypoint Script
Entrypoint script database beklerken takılıyor olabilir. Script'i daha tolerant hale getirdik.

## 🚀 Çözüm Adımları

### Yöntem 1: Nginx Servisi Ekle (Önerilen)

1. Easypanel'de **New Service** oluşturun
2. **Type:** Docker
3. **Image:** `nginx:alpine`
4. **Port:** `8001:80`
5. **Volumes:**
   ```
   /var/www/html:/var/www/html:ro
   docker/nginx/default.conf:/etc/nginx/conf.d/default.conf:ro
   ```
6. **Depends on:** app (PHP-FPM container)

### Yöntem 2: PHP Built-in Server (Basit)

Dockerfile'ı değiştirin:
```dockerfile
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
```

### Yöntem 3: Port Mapping Düzelt

Easypanel'de app ayarlarında:
- **External Port:** `8001`
- **Internal Port:** `80` (Nginx için) veya `8000` (PHP built-in server için)

## 🔍 Debug Adımları

### 1. Container Logs Kontrol
```bash
# Easypanel Terminal'den
docker ps
docker logs <container_id>
```

### 2. Health Check Test
```bash
curl http://localhost:8001/up
```

### 3. Database Bağlantısı
```bash
php artisan db:show
```

### 4. Port Kontrol
```bash
netstat -tuln | grep 8001
```

## 📝 Easypanel Ayarları Checklist

- [ ] App container çalışıyor
- [ ] Port mapping doğru (8001:80 veya 8001:9000)
- [ ] Nginx servisi eklendi (veya PHP built-in server kullanılıyor)
- [ ] Database bağlantısı çalışıyor
- [ ] Health check endpoint çalışıyor (`/up`)
- [ ] Environment variables doğru
- [ ] Storage permissions doğru

---

**Not:** En yaygın sorun Nginx servisinin eksik olmasıdır. PHP-FPM container'ı tek başına web request'leri handle edemez, bir web server (Nginx veya PHP built-in server) gereklidir.

