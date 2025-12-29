# 📱 Setup WhatsApp Alert - Cara Paling Mudah

## 🎯 Masalah yang Sering Terjadi

Jika Anda mengalami masalah:
- ❌ WhatsApp tidak bisa ditautkan
- ❌ QR Code expired terus
- ❌ Server Node.js error
- ❌ Puppeteer/Chromium error

**Solusi:** Gunakan layanan WhatsApp API yang sudah jadi!

---

## ✅ SOLUSI TERMUDAH: Gunakan Fonnte.com

### Keuntungan:
- ✅ Setup cuma 5 menit
- ✅ Tidak perlu install Node.js
- ✅ Tidak perlu scan QR berulang
- ✅ Stabil & reliable
- ✅ Ada free trial
- ✅ Harga terjangkau (mulai 50rb/bulan)

---

## 🚀 Langkah-Langkah Setup

### **Step 1: Daftar di Fonnte**

1. Buka: **https://fonnte.com**
2. Klik **"Daftar"** atau **"Sign Up"**
3. Isi data:
   - Email
   - Password
   - Nomor WhatsApp
4. Verifikasi email
5. Login ke dashboard

### **Step 2: Dapatkan API Token**

1. Di dashboard Fonnte, klik **"API"** atau **"Token"**
2. Copy **Token** Anda (contoh: `abc123xyz456`)
3. Simpan token ini

### **Step 3: Hubungkan WhatsApp**

1. Di dashboard Fonnte, klik **"Device"** atau **"Perangkat"**
2. Scan QR Code dengan WhatsApp Anda
3. Tunggu sampai status **"Connected"**

### **Step 4: Update Laravel .env**

Edit file `.env` di Laravel:

```env
# WhatsApp API Configuration (Fonnte)
WHATSAPP_API_URL=https://api.fonnte.com/send
WHATSAPP_API_KEY=abc123xyz456
WHATSAPP_PHONE_NUMBER=628123456789
```

**Ganti:**
- `abc123xyz456` → Token dari Fonnte
- `628123456789` → Nomor WhatsApp Owner (yang mau terima alert)

### **Step 5: Update WhatsAppService.php**

Edit file `app/Services/WhatsAppService.php`:

Ganti method `sendMessage()` (baris 28-75) dengan:

```php
public function sendMessage(string $to, string $message): array
{
    try {
        // Deteksi provider
        if (str_contains($this->apiUrl, 'fonnte.com')) {
            // Kirim via Fonnte
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => $this->apiKey, // Tanpa "Bearer"
                ])
                ->post($this->apiUrl, [
                    'target' => $to,
                    'message' => $message,
                    'countryCode' => '62',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                Log::info('WhatsApp sent via Fonnte', [
                    'to' => $to,
                    'response' => $data,
                ]);

                return [
                    'success' => $data['status'] ?? false,
                    'data' => $data,
                ];
            }

            Log::error('Fonnte send failed', [
                'to' => $to,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return [
                'success' => false,
                'error' => $response->body(),
            ];
        }

        // Fallback ke custom server
        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post($this->apiUrl . '/send-message', [
                'phone' => $to,
                'message' => $message,
            ]);

        if ($response->successful()) {
            Log::info('WhatsApp sent successfully', [
                'to' => $to,
                'response' => $response->json(),
            ]);

            return [
                'success' => true,
                'data' => $response->json(),
            ];
        }

        Log::error('WhatsApp send failed', [
            'to' => $to,
            'status' => $response->status(),
            'response' => $response->body(),
        ]);

        return [
            'success' => false,
            'error' => $response->body(),
        ];

    } catch (\Exception $e) {
        Log::error('WhatsApp exception', [
            'to' => $to,
            'error' => $e->getMessage(),
        ]);

        return [
            'success' => false,
            'error' => $e->getMessage(),
        ];
    }
}
```

### **Step 6: Test Koneksi**

```bash
php artisan whatsapp:test
```

Jika berhasil, Anda akan terima pesan WhatsApp!

---

## 🧪 Testing

### Via Command Line:

```bash
# Test koneksi
php artisan whatsapp:test

# Test alert
php artisan whatsapp:test-alert
```

### Via Dashboard:

1. Login sebagai Owner
2. Klik menu **"WhatsApp Alert"**
3. Klik **"🔌 Test Koneksi"**
4. Cek WhatsApp Anda

---

## 💰 Harga Fonnte

- **Free Trial**: 100 pesan gratis
- **Paket Reguler**: Mulai 50.000/bulan
- **Unlimited**: 150.000/bulan

Cukup murah untuk fitur auto-alert yang sangat berguna!

---

## 🔄 Alternatif Lain

### **Wablas.com**

Setup mirip dengan Fonnte:

```env
WHATSAPP_API_URL=https://yourdomain.wablas.com/api/send-message
WHATSAPP_API_KEY=your_wablas_token
WHATSAPP_PHONE_NUMBER=628123456789
```

Update `sendMessage()`:

```php
$response = Http::withHeaders([
    'Authorization' => $this->apiKey,
])->post($this->apiUrl, [
    'phone' => $to,
    'message' => $message,
]);
```

---

## ❓ FAQ

### Q: Apakah harus bayar?
A: Ada free trial 100 pesan. Cukup untuk testing.

### Q: Apakah aman?
A: Ya, Fonnte adalah layanan resmi dan terpercaya.

### Q: Bagaimana jika server Node.js tetap ingin dipakai?
A: Bisa, tapi lebih ribet dan sering error. Fonnte lebih stabil.

### Q: Apakah bisa kirim ke banyak nomor?
A: Ya, tinggal ganti parameter `$to`.

---

## ✅ Checklist

- [ ] Daftar di Fonnte.com
- [ ] Dapatkan API Token
- [ ] Scan QR Code di dashboard Fonnte
- [ ] Update .env Laravel
- [ ] Update WhatsAppService.php
- [ ] Test koneksi: `php artisan whatsapp:test`
- [ ] Test alert: `php artisan whatsapp:test-alert`
- [ ] Coba input omset turun > 30%
- [ ] Cek WhatsApp terima alert

---

**Selamat! Sistem WhatsApp Alert siap digunakan! 🎉**

