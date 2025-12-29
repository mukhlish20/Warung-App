# ⚡ Quick Deploy Guide - InfinityFree

## 🎯 Ringkasan Cepat

Deploy Warung App ke InfinityFree dalam **30-60 menit**!

---

## 📋 Yang Anda Butuhkan

- ✅ Akun InfinityFree (gratis)
- ✅ Akses internet
- ✅ Browser
- ✅ FTP Client (opsional, bisa pakai File Manager)

---

## 🚀 3 LANGKAH UTAMA

### **LANGKAH 1: Setup InfinityFree (5-10 menit)**

1. **Daftar di InfinityFree**
   - Buka: https://www.infinityfree.com
   - Klik "Sign Up"
   - Isi email & password
   - Verifikasi email

2. **Buat Hosting Account**
   - Login ke InfinityFree
   - Klik "Create Account"
   - Pilih "Use free subdomain"
   - Masukkan: `warung-app` (atau nama lain)
   - Domain: `.infinityfreeapp.com`
   - Klik "Create Account"
   - **Tunggu 2-5 menit** sampai aktif

3. **Buat Database**
   - Di control panel, klik "MySQL Databases"
   - Klik "Create Database"
   - Database name: `warung_db`
   - Klik "Create"
   - **CATAT** informasi database:
     ```
     Database Name: epiz_XXXXXXXX_warung_db
     Database User: epiz_XXXXXXXX
     Database Password: (auto-generated)
     Database Host: sqlXXX.infinityfree.com
     ```

---

### **LANGKAH 2: Upload File (15-20 menit)**

#### **Opsi A: Via File Manager (Mudah)**

1. **Download Project dari GitHub**
   - Buka: https://github.com/mukhlish20/Warung-App
   - Klik "Code" → "Download ZIP"
   - Extract ZIP

2. **Persiapan File**
   - Buka folder hasil extract
   - Hapus folder: `.git`, `node_modules`, `tests`
   - Hapus file: `.env` (akan dibuat manual)

3. **Upload ke InfinityFree**
   - Di control panel, klik "File Manager"
   - Buka folder `htdocs`
   - **Hapus semua file default** (index.html, dll)
   - Klik "Upload"
   - Upload **SEMUA** file & folder dari project
   - Tunggu sampai selesai (bisa 10-15 menit)

4. **Set Permissions**
   - Klik kanan folder `storage` → Permissions → `755`
   - Klik kanan folder `bootstrap/cache` → Permissions → `755`

#### **Opsi B: Via FTP (Lebih Cepat)**

1. **Download FileZilla**
   - https://filezilla-project.org/

2. **Connect ke Server**
   - Host: `ftpupload.net`
   - Username: `epiz_XXXXXXXX` (dari control panel)
   - Password: (dari control panel)
   - Port: `21`

3. **Upload File**
   - Drag & drop semua file ke folder `htdocs`

---

### **LANGKAH 3: Setup & Deploy (10-15 menit)**

1. **Buat File .env**
   - Di File Manager, buka folder `htdocs`
   - Klik "New File" → Nama: `.env`
   - Edit file `.env`
   - Copy isi dari `.env.infinityfree` (ada di project)
   - **Ganti** dengan info database Anda:
     ```env
     DB_HOST=sqlXXX.infinityfree.com
     DB_DATABASE=epiz_XXXXXXXX_warung_db
     DB_USERNAME=epiz_XXXXXXXX
     DB_PASSWORD=your_password_here
     ```
   - **Ganti** APP_URL:
     ```env
     APP_URL=https://warung-app.infinityfreeapp.com
     ```
   - Save

2. **Generate APP_KEY**
   - Buka file `.env` di local (di komputer Anda)
   - Copy value `APP_KEY=base64:...`
   - Paste ke `.env` di server
   - Save

3. **Run Migration**
   - Buka browser
   - Akses: `https://warung-app.infinityfreeapp.com/migrate.php`
   - Tunggu sampai selesai (2-5 menit)
   - **PENTING:** Hapus file `migrate.php` setelah selesai!

4. **Testing**
   - Buka: `https://warung-app.infinityfreeapp.com`
   - Login dengan:
     ```
     Email: owner@warung.com
     Password: password
     ```
   - ✅ Jika berhasil login, **SELESAI!** 🎉

---

## 🐛 Troubleshooting Cepat

### ❌ Error 500
**Solusi:**
- Cek file `.env` sudah benar
- Cek permission `storage/` = 755
- Set `APP_DEBUG=true` di `.env` untuk lihat error

### ❌ Database Connection Error
**Solusi:**
- Cek credentials database di `.env`
- Pastikan database sudah dibuat
- Cek DB_HOST benar

### ❌ CSS/JS Tidak Muncul
**Solusi:**
- Pastikan folder `public/build/` sudah di-upload
- Cek `APP_URL` di `.env` sudah benar
- Clear browser cache

### ❌ Redirect Loop
**Solusi:**
- Cek file `.htaccess` ada di root dan di `public/`
- Pastikan `APP_URL` di `.env` pakai `https://`

---

## 📞 Butuh Bantuan Detail?

Baca panduan lengkap: **DEPLOYMENT_INFINITYFREE.md**

---

## ✅ Checklist Akhir

Setelah deploy, pastikan:
- [ ] Aplikasi bisa diakses via browser
- [ ] Login berhasil
- [ ] Dashboard muncul
- [ ] Data warung tampil
- [ ] Input omset berhasil
- [ ] Chart muncul
- [ ] File `migrate.php` sudah dihapus

---

## 🎉 Selamat!

Aplikasi Anda sekarang **ONLINE** dan bisa diakses dari mana saja!

**URL:** https://warung-app.infinityfreeapp.com

Share ke teman, portfolio, atau CV Anda! 🚀

---

## 📝 Catatan

- InfinityFree **GRATIS SELAMANYA**
- Cocok untuk demo/portfolio
- Limit: 50,000 hits/day (cukup untuk demo)
- Jika butuh performa lebih, upgrade ke hosting berbayar

---

**Good luck!** 💪

