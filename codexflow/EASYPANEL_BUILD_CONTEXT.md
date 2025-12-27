# Easypanel Build Context Ayarları

## ⚠️ ÖNEMLİ: Build Context Ayarı

Easypanel'de Docker build yaparken **Build Context** ayarını yapmanız gerekiyor.

### Sorun
Dockerfile `codexflow/` klasörü içinde olduğu için, Easypanel root'tan Dockerfile bulamıyor.

### Çözüm

#### Yöntem 1: Build Context Ayarla (Önerilen)

Easypanel'de app ayarlarına gidin:

1. **Settings** → **Build Settings**
2. **Build Context** alanına şunu yazın: `codexflow`
3. **Dockerfile Path** alanına şunu yazın: `codexflow/Dockerfile`
4. **Save** butonuna tıklayın

#### Yöntem 2: Dockerfile'ı Root'a Taşı (Alternatif)

Eğer build context ayarlayamıyorsanız, Dockerfile'ı repository root'una kopyalayın:

```bash
# Root'ta Dockerfile oluştur
cp codexflow/Dockerfile Dockerfile

# Dockerfile'ı root için düzenle (WORKDIR ve COPY path'lerini güncelle)
```

### Easypanel Build Settings

```
Build Context: codexflow
Dockerfile Path: codexflow/Dockerfile
```

veya

```
Build Context: .
Dockerfile Path: codexflow/Dockerfile
```

### Kontrol

Deploy yapmadan önce:
- [ ] Build Context: `codexflow` olarak ayarlandı
- [ ] Dockerfile Path: `codexflow/Dockerfile` olarak ayarlandı
- [ ] docker-compose.yml path'i doğru (eğer kullanılıyorsa)

---

**Not:** Easypanel bazı durumlarda otomatik olarak `codexflow/` klasörünü algılayabilir, ancak manuel ayarlamak daha güvenilirdir.

