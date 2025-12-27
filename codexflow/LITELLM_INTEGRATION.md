# LiteLLM Proxy Entegrasyonu

## 🔗 LiteLLM Proxy ile Laravel Dashboard Entegrasyonu

LiteLLM proxy'nizden (`https://proxyapison-litellmproxyv1.lc58dd.easypanel.host/`) Laravel dashboard'a log göndermek için webhook yapılandırması.

## 📋 Adım 1: Environment Variables

Laravel dashboard `.env` dosyanıza ekleyin:

```env
LITELLM_WEBHOOK_KEY=your_secure_webhook_key_here
LITELLM_PROXY_URL=https://proxyapison-litellmproxyv1.lc58dd.easypanel.host
```

**ÖNEMLİ:** `LITELLM_WEBHOOK_KEY` değerini güçlü bir key ile değiştirin:
```bash
php artisan tinker
echo bin2hex(random_bytes(32));
```

## 📋 Adım 2: LiteLLM Proxy Webhook Yapılandırması

LiteLLM proxy'nizin yapılandırma dosyasına (`config.yaml` veya environment variables) webhook ekleyin:

### Yöntem 1: Environment Variables

```env
WEBHOOK_URL=https://dashboard.codexflow.dev/api/webhook/litellm
WEBHOOK_HEADERS={"X-API-Key": "your_secure_webhook_key_here"}
WEBHOOK_EVENTS=["llm.completion", "llm.streaming", "llm.error"]
```

### Yöntem 2: config.yaml

```yaml
general_settings:
  webhook_url: "https://dashboard.codexflow.dev/api/webhook/litellm"
  webhook_headers:
    X-API-Key: "your_secure_webhook_key_here"
  webhook_events:
    - "llm.completion"
    - "llm.streaming"
    - "llm.error"
```

## 📋 Adım 3: User API Key Mapping

LiteLLM proxy'de her kullanıcının bir API key'i var. Laravel dashboard'da bu API key'i user ile eşleştirmek için:

### User Oluştururken API Key Kaydet

```php
$user = User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password'),
    'api_key' => 'cf_' . bin2hex(random_bytes(32)), // LiteLLM'de kullanılacak key
    'plan' => 'starter',
    'status' => 'active',
]);
```

### LiteLLM Proxy'de User API Key Tanımla

LiteLLM proxy'nizin yapılandırmasında:

```yaml
model_list:
  - model_name: gpt-4
    litellm_params:
      model: gpt-4
      api_key: os.environ/OPENAI_API_KEY

# User API keys
user_config:
  - user_id: "cf_abc123..." # Laravel dashboard'daki api_key
    max_budget: 100.0
    allowed_model_region: ["us-east-1"]
```

## 🔄 Webhook Akışı

```
1. Client → LiteLLM Proxy (API çağrısı)
2. LiteLLM Proxy → AI Provider (OpenAI, Anthropic, vb.)
3. AI Provider → LiteLLM Proxy (Response)
4. LiteLLM Proxy → Laravel Dashboard (Webhook POST)
5. Laravel Dashboard → Database (Log kaydı)
```

## 📊 Webhook Payload Formatı

LiteLLM webhook'u şu formatta veri gönderir:

```json
{
  "user_id": "cf_abc123...",
  "model": "gpt-4",
  "messages": [...],
  "response": {
    "model": "gpt-4",
    "usage": {
      "prompt_tokens": 100,
      "completion_tokens": 50,
      "total_tokens": 150
    },
    "cost": 0.0015,
    "response_time": 1.25
  },
  "status": "success"
}
```

Laravel dashboard bu veriyi otomatik olarak parse eder ve `api_logs` tablosuna kaydeder.

## 🧪 Test

### 1. Webhook Endpoint'ini Test Et

```bash
curl -X POST https://dashboard.codexflow.dev/api/webhook/litellm \
  -H "Content-Type: application/json" \
  -H "X-API-Key: your_secure_webhook_key_here" \
  -d '{
    "user_id": "cf_abc123...",
    "model": "gpt-4",
    "usage": {
      "prompt_tokens": 100,
      "completion_tokens": 50
    },
    "cost": 0.0015,
    "response_time": 1.25,
    "status": "success"
  }'
```

### 2. LiteLLM Proxy'den Test İsteği

```bash
curl -X POST https://proxyapison-litellmproxyv1.lc58dd.easypanel.host/v1/chat/completions \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer cf_abc123..." \
  -d '{
    "model": "gpt-4",
    "messages": [
      {"role": "user", "content": "Hello!"}
    ]
  }'
```

Bu istekten sonra LiteLLM otomatik olarak webhook gönderecek.

## 🔐 Güvenlik

1. **Webhook Key:** Mutlaka güçlü bir key kullanın
2. **HTTPS:** Production'da mutlaka HTTPS kullanın
3. **Rate Limiting:** Webhook endpoint'ine rate limiting ekleyin (opsiyonel)
4. **IP Whitelist:** Sadece LiteLLM proxy IP'sinden gelen isteklere izin verin (opsiyonel)

## 📈 Dashboard'da Görüntüleme

Webhook'tan gelen loglar otomatik olarak:
- Dashboard'da görüntülenir
- Analytics'te hesaplanır
- Rate limit'lere eklenir
- Export edilebilir

## 🐛 Troubleshooting

### Webhook Çalışmıyor

1. **Logs kontrol edin:**
```bash
docker-compose logs -f app
# veya
tail -f storage/logs/laravel.log
```

2. **Webhook key kontrol:**
- Laravel `.env` dosyasında `LITELLM_WEBHOOK_KEY`
- LiteLLM proxy'de `WEBHOOK_HEADERS` içinde aynı key

3. **User bulunamıyor:**
- User'ın `api_key` değerinin LiteLLM'deki `user_id` ile eşleştiğinden emin olun

### User Mapping Hatası

Eğer `user_id` ile user bulunamazsa, webhook'ta `metadata` içinde `laravel_user_id` gönderebilirsiniz:

```json
{
  "user_id": "cf_abc123...",
  "metadata": {
    "laravel_user_id": 1
  },
  ...
}
```

## 📝 Örnek LiteLLM Config

```yaml
# LiteLLM Proxy Config
model_list:
  - model_name: gpt-4
    litellm_params:
      model: gpt-4
      api_key: os.environ/OPENAI_API_KEY

general_settings:
  webhook_url: "https://dashboard.codexflow.dev/api/webhook/litellm"
  webhook_headers:
    X-API-Key: "your_secure_webhook_key_here"
  webhook_events:
    - "llm.completion"
    - "llm.error"

user_config:
  - user_id: "cf_abc123..."
    max_budget: 100.0
    allowed_models: ["gpt-4", "gpt-3.5-turbo"]
```

---

**Entegrasyon tamamlandı! 🚀**

LiteLLM proxy'nizden gelen tüm API çağrıları otomatik olarak Laravel dashboard'a kaydedilecek.

