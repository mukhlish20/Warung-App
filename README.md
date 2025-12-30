# 🏪 Warung App - Sistem Manajemen Omset Warung

Aplikasi web untuk mengelola omset harian warung dengan fitur pembagian profit otomatis dan notifikasi WhatsApp ketika omset turun.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## 🌐 Live Demo

**🚀 [https://warungmadura-app.infinityfreeapp.com](https://warungmadura-app.infinityfreeapp.com)**

**Login Credentials:**
- **Owner:** `owner@warung.com` / `password`
- **Penjaga:** `penjaga1@warung.com` / `password`

---

## 📋 Daftar Isi

- [Live Demo](#-live-demo)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Penggunaan](#-penggunaan)
- [Fitur WhatsApp Alert](#-fitur-whatsapp-alert)
- [Deployment](#-deployment)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## ✨ Fitur Utama

### 👤 **Untuk Owner (Pemilik Warung)**

- ✅ **Dashboard Interaktif**
  - Grafik omset per cabang (Bar Chart)
  - Grafik omset harian (Line Chart)
  - Grafik pembagian profit (Doughnut Chart)
  - Summary omset hari ini, bulan ini, dan total profit
  - Alert visual ketika omset turun signifikan

- ✅ **Kelola Warung**
  - Tambah, edit, hapus cabang warung
  - Soft delete (data tidak hilang permanen)
  - Informasi lengkap: nama, alamat, no HP, catatan

- ✅ **Kelola Penjaga**
  - Tambah, edit, hapus akun penjaga
  - Assign penjaga ke cabang tertentu
  - Aktifkan/nonaktifkan akun penjaga
  - Reset password penjaga

- ✅ **Laporan Omset**
  - Filter berdasarkan bulan, tahun, dan cabang
  - Tabel detail omset harian
  - Summary total omset, profit, dan pembagian
  - Export ke Excel (.xlsx)
  - Export ke PDF

- ✅ **WhatsApp Alert**
  - Notifikasi otomatis ketika omset turun > 30%
  - Dashboard monitoring alert
  - Test koneksi WhatsApp API
  - Riwayat 20 alert terakhir
  - Konfigurasi API via dashboard

### 👥 **Untuk Penjaga**

- ✅ **Dashboard Penjaga**
  - Ringkasan omset dan profit bulanan
  - Grafik omset harian warung sendiri
  - Filter bulan dan tahun

- ✅ **Input Omset Harian**
  - Form input omset sederhana
  - Kalkulasi profit otomatis (10% dari omset)
  - Pembagian profit 50:50 (Owner:Penjaga)
  - Validasi: 1 input per hari
  - Edit omset hari yang sama

- ✅ **Riwayat Omset**
  - Lihat riwayat input omset
  - Filter berdasarkan periode

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12.x
- **Frontend:** Blade Templates, Chart.js
- **Database:** MySQL
- **Export:** Laravel Excel, DomPDF
- **WhatsApp API:** Fonnte.com (atau custom Node.js)
- **Authentication:** Laravel Auth
- **Styling:** Custom CSS (Responsive)

---

## 📦 Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL >= 5.7 atau MariaDB
- Node.js & NPM (untuk build assets)
- Web Server (Apache/Nginx) atau Laravel Valet/Laragon

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/mukhlish20/Warung-App.git
cd Warung-App
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install NPM dependencies
npm install
```

### 3. Setup Environment

```bash
# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=warung_app
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi Database

```bash
# Jalankan migrasi
php artisan migrate

# (Opsional) Seed data dummy
php artisan db:seed --class=DummyDataSeeder
```

### 6. Build Assets

```bash
npm run build
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

---

## ⚙️ Konfigurasi

### WhatsApp Alert (Opsional)

Untuk mengaktifkan fitur WhatsApp alert, tambahkan konfigurasi di `.env`:

```env
WHATSAPP_API_URL=https://api.fonnte.com/send
WHATSAPP_API_KEY=your_fonnte_api_key
WHATSAPP_PHONE_NUMBER=628xxxxxxxxxx
```

**Cara mendapatkan API Key:**
1. Daftar di [Fonnte.com](https://fonnte.com)
2. Dapatkan API Token gratis (1000 pesan/bulan)
3. Scan QR Code untuk connect WhatsApp
4. Copy API Token ke `.env`

Lihat panduan lengkap: [SETUP_WHATSAPP_MUDAH.md](SETUP_WHATSAPP_MUDAH.md)

---

## 📖 Penggunaan

### Login Credentials (Setelah Seeding)

**Owner:**
```
Email: owner@warung.com
Password: password
```

**Penjaga:**
```
Email: penjaga1@warung.com
Password: password
```

### Workflow Aplikasi

1. **Owner** membuat cabang warung
2. **Owner** membuat akun penjaga dan assign ke cabang
3. **Penjaga** login dan input omset harian
4. **Sistem** otomatis hitung profit dan pembagian
5. **Sistem** kirim alert WhatsApp jika omset turun > 30%
6. **Owner** monitoring via dashboard dan laporan

---

## 📱 Fitur WhatsApp Alert

### Cara Kerja

1. **Penjaga** input omset hari ini
2. **Sistem** hitung rata-rata omset 7 hari terakhir
3. **Jika omset turun > 30%**, sistem kirim alert WhatsApp ke Owner
4. **Alert hanya dikirim 1x per hari** (tidak spam)
5. **Semua alert tercatat** di database untuk monitoring

### Format Pesan Alert

```
🚨 *ALERT OMSET TURUN* 🚨

📅 Tanggal: 29/12/2024
🕐 Waktu: 15:30

⚠️ Omset hari ini turun *40%*

📊 *Detail:*
• Omset Hari Ini: Rp 1.2 jt
• Rata-rata 7 Hari: Rp 2.0 jt
• Selisih: Rp 800 rb

💡 Mohon segera dicek kondisi warung.

_Warung App - Automated Alert_
```

### Test Alert

```bash
# Test koneksi WhatsApp API
php artisan whatsapp:test

# Kirim test alert
php artisan whatsapp:test-alert
```

---

## 📊 Data Dummy

Aplikasi sudah dilengkapi dengan seeder untuk data dummy:

```bash
php artisan db:seed --class=DummyDataSeeder
```

**Data yang dibuat:**
- 1 Owner (Budi Santoso)
- 3 Warung (Cabang Pusat, Timur, Selatan)
- 3 Penjaga (1 per cabang)
- 90 Omset Harian (30 hari × 3 cabang)
- 3 Riwayat Alert

---

## 🗂️ Struktur Database

### Tabel Utama

**users**
- id, name, email, password, role (owner/penjaga), warung_id

**warungs**
- id, nama_warung, alamat, no_hp, catatan, deleted_at

**omset_harians**
- id, warung_id, tanggal, omset, profit, owner_profit, penjaga_profit

**omset_alerts**
- id, tanggal, omset_hari_ini, avg_7_hari, persentase_turun, whatsapp_sent, whatsapp_response, sent_at

---

## 🎨 Fitur UI/UX

- ✅ **Responsive Design** - Mobile, Tablet, Desktop
- ✅ **Dark Mode Ready** - Warna yang nyaman di mata
- ✅ **Interactive Charts** - Chart.js dengan animasi smooth
- ✅ **Clean Interface** - Minimalis dan mudah digunakan
- ✅ **Alert Notifications** - Visual feedback untuk setiap aksi
- ✅ **Loading States** - Indikator loading untuk UX yang baik

---

## 🧪 Testing

### Manual Testing

1. **Test Login**
   - Login sebagai Owner
   - Login sebagai Penjaga
   - Test logout

2. **Test CRUD Warung**
   - Tambah warung baru
   - Edit warung
   - Hapus warung (soft delete)

3. **Test Input Omset**
   - Input omset hari ini
   - Cek kalkulasi profit otomatis
   - Test validasi (tidak bisa input 2x di hari yang sama)

4. **Test Export**
   - Export laporan ke Excel
   - Export laporan ke PDF

5. **Test WhatsApp Alert**
   - Input omset turun > 30%
   - Cek WhatsApp Owner menerima alert
   - Cek riwayat alert di dashboard

---

## 🔒 Security

- ✅ **Authentication** - Laravel Auth
- ✅ **Authorization** - Middleware untuk Owner & Penjaga
- ✅ **CSRF Protection** - Token CSRF di semua form
- ✅ **Password Hashing** - Bcrypt
- ✅ **SQL Injection Prevention** - Eloquent ORM
- ✅ **XSS Protection** - Blade escaping

---

## 🚀 Deployment

### Live Demo

Aplikasi ini sudah di-deploy di **InfinityFree** (Free Hosting):

**🌐 URL:** [https://warungmadura-app.infinityfreeapp.com](https://warungmadura-app.infinityfreeapp.com)

**Login Credentials:**
- **Owner:** `owner@warung.com` / `password`
- **Penjaga:** `penjaga1@warung.com` / `password`

**Fitur yang Aktif:**
- ✅ Dashboard Owner & Penjaga
- ✅ Kelola Warung & Penjaga
- ✅ Input Omset Harian
- ✅ Laporan & Export (Excel/PDF)
- ✅ Grafik Interaktif (Chart.js)
- ⚠️ WhatsApp Alert (Disabled - API berbayar)

### Production Checklist

- [x] Set `APP_ENV=production` di `.env`
- [x] Set `APP_DEBUG=false` di `.env`
- [x] Generate production key: `php artisan key:generate`
- [x] Optimize autoloader: `composer install --optimize-autoloader --no-dev`
- [x] Cache config: `php artisan config:cache`
- [x] Cache routes: `php artisan route:cache`
- [x] Cache views: `php artisan view:cache`
- [x] Setup SSL/HTTPS (InfinityFree auto SSL)
- [ ] Setup backup database otomatis
- [ ] Setup monitoring & logging

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan:

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📝 Lisensi

Project ini menggunakan lisensi [MIT License](LICENSE).

---

## 👨‍💻 Author

Dibuat dengan ❤️ untuk memudahkan pengelolaan warung

---

## 📞 Support

Jika ada pertanyaan atau masalah, silakan buat [Issue](https://github.com/mukhlish20/Warung-App/issues) di GitHub.

---

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - Framework PHP terbaik
- [Chart.js](https://www.chartjs.org) - Library charting yang powerful
- [Fonnte](https://fonnte.com) - WhatsApp API yang mudah digunakan
- [Laravel Excel](https://laravel-excel.com) - Export Excel yang mudah
- [DomPDF](https://github.com/barryvdh/laravel-dompdf) - Generate PDF di Laravel

---

**Happy Coding! 🚀**
