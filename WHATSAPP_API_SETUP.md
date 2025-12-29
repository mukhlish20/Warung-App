# 📱 Setup WhatsApp API untuk Alert Omset Turun

## 🎯 Fitur

Sistem ini akan **otomatis mengirim alert WhatsApp** ketika:
- Omset hari ini turun **lebih dari 30%** dibanding rata-rata 7 hari terakhir
- Alert hanya dikirim **1x per hari** (tidak spam)
- Mencatat semua riwayat alert di database

---

## 🚀 Cara Setup WhatsApp API Sendiri

### **Opsi 1: Menggunakan WhatsApp Web API (Node.js)**

#### 1. Install Dependencies

```bash
npm install whatsapp-web.js qrcode-terminal express
```

#### 2. Buat File `whatsapp-server.js`

```javascript
const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const express = require('express');

const app = express();
app.use(express.json());

const client = new Client({
    authStrategy: new LocalAuth()
});

client.on('qr', (qr) => {
    console.log('Scan QR Code ini dengan WhatsApp:');
    qrcode.generate(qr, { small: true });
});

client.on('ready', () => {
    console.log('✅ WhatsApp Client is ready!');
});

client.initialize();

// Endpoint untuk kirim pesan
app.post('/send-message', async (req, res) => {
    const { phone, message } = req.body;
    
    try {
        const chatId = phone + '@c.us';
        await client.sendMessage(chatId, message);
        
        res.json({
            success: true,
            message: 'Pesan berhasil dikirim'
        });
    } catch (error) {
        res.status(500).json({
            success: false,
            error: error.message
        });
    }
});

const PORT = 3000;
app.listen(PORT, () => {
    console.log(`🚀 WhatsApp API Server running on port ${PORT}`);
});
```

#### 3. Jalankan Server

```bash
node whatsapp-server.js
```

#### 4. Scan QR Code

- QR Code akan muncul di terminal
- Scan dengan WhatsApp di HP Anda
- Tunggu sampai muncul "WhatsApp Client is ready!"

---

### **Opsi 2: Menggunakan Baileys (Lebih Ringan)**

```bash
npm install @whiskeysockets/baileys qrcode-terminal express
```

File `baileys-server.js`:

```javascript
const { default: makeWASocket, DisconnectReason, useMultiFileAuthState } = require('@whiskeysockets/baileys');
const express = require('express');
const qrcode = require('qrcode-terminal');

const app = express();
app.use(express.json());

let sock;

async function connectToWhatsApp() {
    const { state, saveCreds } = await useMultiFileAuthState('auth_info_baileys');
    
    sock = makeWASocket({
        auth: state,
        printQRInTerminal: true
    });

    sock.ev.on('creds.update', saveCreds);
    
    sock.ev.on('connection.update', (update) => {
        const { connection, lastDisconnect } = update;
        if(connection === 'close') {
            const shouldReconnect = lastDisconnect?.error?.output?.statusCode !== DisconnectReason.loggedOut;
            if(shouldReconnect) {
                connectToWhatsApp();
            }
        } else if(connection === 'open') {
            console.log('✅ WhatsApp Connected!');
        }
    });
}

connectToWhatsApp();

app.post('/send-message', async (req, res) => {
    const { phone, message } = req.body;
    
    try {
        const jid = phone + '@s.whatsapp.net';
        await sock.sendMessage(jid, { text: message });
        
        res.json({ success: true });
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

app.listen(3000, () => {
    console.log('🚀 Baileys WhatsApp API running on port 3000');
});
```

---

## ⚙️ Konfigurasi Laravel

### 1. Edit File `.env`

```env
WHATSAPP_API_URL=http://localhost:3000
WHATSAPP_API_KEY=your_secret_key_here
WHATSAPP_PHONE_NUMBER=628123456789
```

**Catatan:**
- `WHATSAPP_PHONE_NUMBER` adalah nomor tujuan (Owner)
- Format: 628xxx (tanpa +, tanpa spasi)

### 2. Jalankan Migration

```bash
php artisan migrate
```

### 3. Test Koneksi

```bash
php artisan whatsapp:test
```

### 4. Test Alert

```bash
php artisan whatsapp:test-alert
```

---

## 📊 Cara Kerja Sistem

### 1. **Trigger Otomatis**

Ketika penjaga input omset hari ini:
```
Omset Hari Ini: Rp 1.000.000
Rata-rata 7 Hari: Rp 2.000.000
Penurunan: 50%
```

Jika turun > 30%, sistem akan:
1. ✅ Trigger event `OmsetTurunDetected`
2. ✅ Listener `SendWhatsAppAlert` kirim WhatsApp
3. ✅ Simpan log ke database `omset_alerts`

### 2. **Format Pesan WhatsApp**

```
🚨 *ALERT OMSET TURUN* 🚨

📅 Tanggal: 29/12/2024
🕐 Waktu: 15:30

⚠️ Omset hari ini turun *50%*

📊 *Detail:*
• Omset Hari Ini: Rp 1.0 jt
• Rata-rata 7 Hari: Rp 2.0 jt
• Selisih: Rp 1.0 jt

💡 Mohon segera dicek kondisi warung.

_Warung App - Automated Alert_
```

---

## 🔧 Monitoring & Testing

### Via Web Dashboard

1. Login sebagai Owner
2. Klik menu **"WhatsApp Alert"**
3. Lihat:
   - ✅ Konfigurasi API
   - ✅ Riwayat alert
   - ✅ Test koneksi
   - ✅ Test kirim alert

### Via Command Line

```bash
# Test koneksi
php artisan whatsapp:test

# Kirim test alert
php artisan whatsapp:test-alert
```

---

## 🛡️ Security Tips

1. **Jangan commit API Key** ke Git
2. Gunakan `.env` untuk konfigurasi
3. Tambahkan authentication di WhatsApp API server
4. Gunakan HTTPS untuk production

---

## 🐛 Troubleshooting

### Error: "Connection refused"
- Pastikan WhatsApp API server sudah running
- Cek port 3000 tidak dipakai aplikasi lain

### Error: "QR Code expired"
- Restart WhatsApp API server
- Scan QR code lagi

### Alert tidak terkirim
- Cek log: `storage/logs/laravel.log`
- Test koneksi via dashboard
- Pastikan nomor WhatsApp format benar (628xxx)

---

## 📚 Resources

- [whatsapp-web.js Documentation](https://wwebjs.dev/)
- [Baileys Documentation](https://github.com/WhiskeySockets/Baileys)

---

**Selamat! Sistem WhatsApp Alert sudah siap digunakan! 🎉**

