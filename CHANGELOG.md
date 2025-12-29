# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-12-29

### Added

#### 🎯 Core Features
- **Authentication System**
  - Login/Logout functionality
  - Role-based access (Owner & Penjaga)
  - Middleware untuk authorization

#### 👤 Owner Features
- **Dashboard Interaktif**
  - Grafik omset per cabang (Bar Chart)
  - Grafik omset harian (Line Chart)
  - Grafik pembagian profit (Doughnut Chart)
  - Summary cards (omset hari ini, bulan ini, total profit, jumlah cabang)
  - Alert visual ketika omset turun signifikan
  - Responsive layout untuk semua ukuran layar

- **Kelola Warung**
  - CRUD cabang warung
  - Soft delete untuk data safety
  - Form lengkap: nama, alamat, no HP, catatan

- **Kelola Penjaga**
  - CRUD akun penjaga
  - Assign penjaga ke cabang
  - Aktifkan/nonaktifkan akun
  - Reset password

- **Laporan Omset**
  - Filter berdasarkan bulan, tahun, cabang
  - Tabel detail omset harian
  - Summary total omset dan profit
  - Export ke Excel (.xlsx)
  - Export ke PDF

- **WhatsApp Alert Dashboard**
  - Monitoring konfigurasi API
  - Test koneksi WhatsApp
  - Kirim test alert
  - Riwayat 20 alert terakhir
  - Status pengiriman alert

#### 👥 Penjaga Features
- **Dashboard Penjaga**
  - Ringkasan omset dan profit bulanan
  - Grafik omset harian
  - Filter bulan dan tahun

- **Input Omset Harian**
  - Form input omset sederhana
  - Kalkulasi profit otomatis (10% dari omset)
  - Pembagian profit 50:50 (Owner:Penjaga)
  - Validasi: 1 input per hari
  - Edit omset hari yang sama

#### 📱 WhatsApp Alert System
- **Auto Alert**
  - Deteksi omset turun > 30% dari rata-rata 7 hari
  - Kirim notifikasi WhatsApp otomatis ke Owner
  - Prevent duplicate: 1 alert per hari
  - Log semua alert ke database

- **Integration**
  - Support Fonnte.com API
  - Support custom WhatsApp Web API (Node.js)
  - Configurable via .env
  - Test commands via Artisan

#### 🎨 UI/UX
- **Responsive Design**
  - Mobile-first approach
  - Tablet optimization
  - Desktop optimization
  - Grid layout yang adaptive

- **Interactive Charts**
  - Chart.js integration
  - Smooth animations
  - Tooltip dengan format rupiah
  - Color scheme yang konsisten

- **Clean Interface**
  - Minimalist design
  - Intuitive navigation
  - Visual feedback untuk setiap aksi
  - Loading states

#### 🛠️ Technical Features
- **Database**
  - Migration files lengkap
  - Seeder untuk data dummy
  - Foreign key constraints
  - Soft deletes
  - Unique constraints

- **Export Features**
  - Laravel Excel integration
  - DomPDF integration
  - Custom export templates
  - Format rupiah di export

- **Helper Functions**
  - `rupiah()` - Format angka ke rupiah lengkap
  - `rupiahShort()` - Format angka ke rupiah singkat (jt, rb)

- **Artisan Commands**
  - `whatsapp:test` - Test koneksi WhatsApp API
  - `whatsapp:test-alert` - Kirim test alert

#### 📚 Documentation
- README.md lengkap dengan instalasi dan fitur
- CONTRIBUTING.md untuk panduan kontribusi
- SETUP_WHATSAPP_MUDAH.md untuk setup WhatsApp API
- WHATSAPP_API_SETUP.md untuk setup custom API
- CHANGELOG.md untuk tracking perubahan
- LICENSE (MIT)

### Security
- CSRF protection di semua form
- Password hashing dengan Bcrypt
- SQL injection prevention via Eloquent ORM
- XSS protection via Blade escaping
- Role-based authorization
- Input validation

### Performance
- Eager loading untuk relasi
- Query optimization
- Asset minification
- Cache configuration ready

---

## [Unreleased]

### Planned Features
- [ ] Multi-language support (ID/EN)
- [ ] Email notifications
- [ ] Advanced analytics
- [ ] Mobile app (PWA)
- [ ] API endpoints untuk mobile
- [ ] Backup & restore database
- [ ] Activity logs
- [ ] Advanced reporting

---

**Note:** Untuk detail perubahan di versi mendatang, lihat [Issues](https://github.com/mukhlish20/Warung-App/issues) dan [Pull Requests](https://github.com/mukhlish20/Warung-App/pulls).

