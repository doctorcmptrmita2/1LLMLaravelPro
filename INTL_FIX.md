# 🔧 PHP intl Extension Hatası Düzeltmesi

## Sorun
```
The "intl" PHP extension is required to use the [format] method.
```

Laravel'in Number sınıfı `intl` extension'ını gerektiriyor.

## ✅ Çözüm

### 1. Dockerfile'a intl Extension Eklendi

```dockerfile
# libicu-dev eklendi (intl için gerekli)
libicu-dev \

# intl extension eklendi
&& docker-php-ext-install ... intl \
```

### 2. Entrypoint Script Düzeltildi

`php artisan db:show` komutu `intl` extension gerektirdiği için, basit bir PDO connection test'i kullanılıyor.

## 🚀 Deploy

```bash
git add .
git commit -m "fix: Add PHP intl extension and fix database connection check"
git push origin main
```

Easypanel'de yeniden deploy yapın.

## 📝 Not

- `intl` extension Laravel'in Number formatting için gerekli
- Database connection test artık `intl` gerektirmiyor
- Container restart sonrası çalışacak

---

**Deploy sonrası test edin! 🚀**

