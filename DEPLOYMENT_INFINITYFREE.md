# 🚀 Panduan Deploy ke InfinityFree

## 📋 Checklist Persiapan

- [ ] Akun InfinityFree sudah dibuat
- [ ] Hosting account sudah dibuat
- [ ] Database sudah dibuat
- [ ] FTP credentials sudah dicatat

---

## 🔧 STEP 1: Daftar InfinityFree

### 1.1 Buat Akun
1. Buka https://www.infinityfree.com
2. Klik **"Sign Up"**
3. Isi form:
   - Email: (email Anda)
   - Password: (password kuat)
4. Verifikasi email

### 1.2 Buat Hosting Account
1. Login ke InfinityFree
2. Klik **"Create Account"**
3. Pilih **"Use own domain"** atau **"Use free subdomain"**
4. Jika subdomain:
   - Masukkan nama: `warung-app` (atau nama lain)
   - Pilih domain: `.infinityfreeapp.com`
   - Hasil: `warung-app.infinityfreeapp.com`
5. Klik **"Create Account"**
6. Tunggu 2-5 menit sampai account aktif

---

## 🗄️ STEP 2: Setup Database

### 2.1 Buat Database MySQL
1. Di control panel, klik **"MySQL Databases"**
2. Klik **"Create Database"**
3. Database name: `warung_db` (atau nama lain)
4. Klik **"Create"**

### 2.2 Catat Informasi Database
Setelah database dibuat, catat:
```
Database Name: epiz_XXXXXXXX_warung_db
Database User: epiz_XXXXXXXX
Database Password: (password yang digenerate)
Database Host: sqlXXX.infinityfree.com
```

**PENTING:** Simpan informasi ini, akan dipakai nanti!

---

## 📁 STEP 3: Persiapan File di Local

### 3.1 Clone Repository (Jika belum)
```bash
cd c:\laragon\www
git clone https://github.com/mukhlish20/Warung-App.git
cd Warung-App
```

### 3.2 Install Dependencies
```bash
# Install Composer dependencies
composer install --optimize-autoloader --no-dev

# Install NPM dependencies
npm install

# Build assets
npm run build
```

### 3.3 Optimize untuk Production
```bash
# Optimize autoload
composer dump-autoload --optimize

# Cache config (opsional, bisa di server)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3.4 Update .env untuk Production
Buat file `.env.production` dengan isi:
```env
APP_NAME="Warung App"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://warung-app.infinityfreeapp.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=sqlXXX.infinityfree.com
DB_PORT=3306
DB_DATABASE=epiz_XXXXXXXX_warung_db
DB_USERNAME=epiz_XXXXXXXX
DB_PASSWORD=your_database_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# WhatsApp API (Fonnte)
WHATSAPP_API_URL=https://api.fonnte.com/send
WHATSAPP_API_TOKEN=your_fonnte_token_here
```

**Ganti:**
- `YOUR_APP_KEY_HERE` dengan key dari `.env` lokal Anda
- `sqlXXX.infinityfree.com` dengan host database Anda
- `epiz_XXXXXXXX_warung_db` dengan nama database Anda
- `epiz_XXXXXXXX` dengan username database Anda
- `your_database_password` dengan password database Anda
- `warung-app.infinityfreeapp.com` dengan domain Anda

---

## 📤 STEP 4: Upload File

### 4.1 Akses File Manager
1. Di control panel InfinityFree, klik **"File Manager"**
2. Atau gunakan FTP client (FileZilla)

### 4.2 Upload Semua File
**Via File Manager:**
1. Buka folder `htdocs`
2. **HAPUS** semua file default (index.html, dll)
3. Upload semua file & folder dari project Laravel:
   ```
   ✅ app/
   ✅ bootstrap/
   ✅ config/
   ✅ database/
   ✅ public/
   ✅ resources/
   ✅ routes/
   ✅ storage/
   ✅ vendor/
   ✅ .htaccess (root)
   ✅ artisan
   ✅ composer.json
   ✅ composer.lock
   ✅ package.json
   ```

**JANGAN upload:**
- ❌ `.env` (buat manual di server)
- ❌ `.git/`
- ❌ `node_modules/`
- ❌ `tests/`

### 4.3 Set Permissions
Set permission folder `storage` dan `bootstrap/cache`:
1. Klik kanan folder `storage` → **Permissions** → `755`
2. Klik kanan folder `bootstrap/cache` → **Permissions** → `755`

---

## 🔐 STEP 5: Setup Environment

### 5.1 Buat File .env
1. Di File Manager, buka folder `htdocs`
2. Klik **"New File"** → Nama: `.env`
3. Edit file `.env`
4. Copy isi dari `.env.production` yang sudah dibuat
5. Save

### 5.2 Generate Application Key (Jika belum ada)
Jika APP_KEY masih kosong:
1. Buka terminal/command prompt lokal
2. Jalankan: `php artisan key:generate --show`
3. Copy key yang muncul
4. Paste ke `.env` di server

---

## 🗄️ STEP 6: Import Database

### 6.1 Export Database dari Local
```bash
# Di local
php artisan migrate:fresh --seed
```

Lalu export via phpMyAdmin atau command:
```bash
mysqldump -u root warung_app > warung_app.sql
```

### 6.2 Import ke InfinityFree
1. Di control panel, klik **"phpMyAdmin"**
2. Login dengan credentials database
3. Pilih database Anda
4. Klik tab **"Import"**
5. Choose file: `warung_app.sql`
6. Klik **"Go"**

**ATAU** jalankan migrations di server (lihat STEP 7)

---

## 🚀 STEP 7: Run Migrations (Alternatif)

Karena InfinityFree tidak ada SSH, buat file helper:

### 7.1 Buat file `migrate.php` di root
```php
<?php
// migrate.php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArrayInput([
        'command' => 'migrate:fresh',
        '--seed' => true,
        '--force' => true,
    ]),
    new Symfony\Component\Console\Output\ConsoleOutput
);

echo "Migration completed with status: " . $status;

$kernel->terminate($input, $status);
```

### 7.2 Jalankan via Browser
1. Upload file `migrate.php` ke root
2. Buka: `https://warung-app.infinityfreeapp.com/migrate.php`
3. Tunggu sampai selesai
4. **HAPUS** file `migrate.php` setelah selesai (PENTING!)

---

## ✅ STEP 8: Testing

### 8.1 Akses Aplikasi
Buka: `https://warung-app.infinityfreeapp.com`

### 8.2 Test Login
```
Owner:
Email: owner@warung.com
Password: password

Penjaga:
Email: penjaga1@warung.com
Password: password
```

### 8.3 Test Fitur
- [ ] Login berhasil
- [ ] Dashboard muncul
- [ ] Data warung tampil
- [ ] Input omset berhasil
- [ ] Chart muncul
- [ ] Export Excel/PDF berhasil

---

## 🐛 Troubleshooting

### Error 500
- Cek file `.env` sudah benar
- Cek permission `storage/` dan `bootstrap/cache/` = 755
- Cek `APP_DEBUG=true` untuk lihat error detail

### Database Connection Error
- Cek credentials database di `.env`
- Pastikan database sudah dibuat
- Cek DB_HOST benar

### Assets Tidak Muncul (CSS/JS)
- Cek `APP_URL` di `.env` sudah benar
- Jalankan `npm run build` di local sebelum upload
- Upload folder `public/build/`

### WhatsApp Tidak Jalan
- Cek `WHATSAPP_API_TOKEN` di `.env`
- Test manual via Postman/browser

---

## 📝 Catatan Penting

### Limitations InfinityFree:
- ⚠️ Tidak ada SSH access
- ⚠️ Tidak bisa run `php artisan` via terminal
- ⚠️ Harus pakai workaround (file helper)
- ⚠️ Max 50,000 hits/day
- ⚠️ Agak lambat (tapi OK untuk demo)

### Best Practices:
- ✅ Selalu backup database
- ✅ Jangan simpan data sensitif di code
- ✅ Gunakan `.env` untuk config
- ✅ Set `APP_DEBUG=false` di production
- ✅ Hapus file helper setelah dipakai

---

## 🎉 Selesai!

Aplikasi Anda sekarang online di:
**https://warung-app.infinityfreeapp.com**

Selamat! 🎊

---

## 📞 Butuh Bantuan?

Jika ada masalah:
1. Cek error log di `storage/logs/laravel.log`
2. Set `APP_DEBUG=true` untuk lihat error detail
3. Buat issue di GitHub
4. Tanya di forum InfinityFree

---

**Good luck!** 🚀

