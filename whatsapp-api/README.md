# 📱 WhatsApp API Server untuk Warung App

Server API sederhana untuk mengirim pesan WhatsApp menggunakan whatsapp-web.js

## 🚀 Quick Start

### 1. Install Dependencies

```bash
cd whatsapp-api
npm install
```

### 2. Setup Environment

```bash
cp .env.example .env
```

Edit `.env` sesuai kebutuhan:
```env
PORT=3000
API_KEY=warung-app-secret-key
```

### 3. Jalankan Server

```bash
npm start
```

Atau untuk development (auto-reload):
```bash
npm run dev
```

### 4. Scan QR Code

- QR Code akan muncul di terminal
- Buka WhatsApp di HP
- Pilih **Linked Devices** → **Link a Device**
- Scan QR Code yang muncul
- Tunggu sampai muncul "WhatsApp Client is ready!"

## 📡 API Endpoints

### 1. Health Check

```bash
GET http://localhost:3000/health
```

Response:
```json
{
  "success": true,
  "status": "ready",
  "timestamp": "2024-12-29T10:30:00.000Z"
}
```

### 2. Send Message

```bash
POST http://localhost:3000/send-message
Headers:
  Authorization: Bearer warung-app-secret-key
  Content-Type: application/json

Body:
{
  "phone": "628123456789",
  "message": "Test pesan dari Warung App"
}
```

Response:
```json
{
  "success": true,
  "message": "Message sent successfully",
  "to": "628123456789",
  "timestamp": "2024-12-29T10:30:00.000Z"
}
```

### 3. Get Client Info

```bash
GET http://localhost:3000/info
Headers:
  Authorization: Bearer warung-app-secret-key
```

Response:
```json
{
  "success": true,
  "data": {
    "phone": "628123456789",
    "platform": "android",
    "pushname": "Your Name"
  }
}
```

## 🔧 Testing dengan cURL

```bash
# Health check
curl http://localhost:3000/health

# Send message
curl -X POST http://localhost:3000/send-message \
  -H "Authorization: Bearer warung-app-secret-key" \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "628123456789",
    "message": "Test dari cURL"
  }'
```

## 📝 Notes

- Session WhatsApp disimpan di folder `wa-session/`
- Setelah scan QR pertama kali, session akan tersimpan
- Tidak perlu scan QR lagi kecuali logout dari WhatsApp
- Server harus tetap running untuk menerima request

## 🐛 Troubleshooting

### QR Code tidak muncul
- Pastikan tidak ada WhatsApp Web yang sudah login
- Hapus folder `wa-session/` dan restart server

### Error "WhatsApp client is not ready"
- Tunggu beberapa detik setelah scan QR
- Cek status dengan endpoint `/health`

### Session expired
- Hapus folder `wa-session/`
- Restart server dan scan QR lagi

## 🚀 Production Tips

1. Gunakan PM2 untuk auto-restart:
```bash
npm install -g pm2
pm2 start server.js --name whatsapp-api
pm2 save
pm2 startup
```

2. Gunakan reverse proxy (nginx) untuk HTTPS

3. Ganti API_KEY dengan key yang lebih aman

4. Monitor logs:
```bash
pm2 logs whatsapp-api
```

