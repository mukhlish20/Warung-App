# 🤝 Contributing to Warung App

Terima kasih telah tertarik untuk berkontribusi pada Warung App! Kami sangat menghargai kontribusi dari komunitas.

## 📋 Cara Berkontribusi

### 1. Fork Repository

Klik tombol "Fork" di pojok kanan atas halaman repository ini.

### 2. Clone Fork Anda

```bash
git clone https://github.com/mukhlish20/Warung-App.git
cd Warung-App
```

### 3. Buat Branch Baru

```bash
git checkout -b feature/nama-fitur-anda
```

Gunakan naming convention:
- `feature/` untuk fitur baru
- `bugfix/` untuk perbaikan bug
- `docs/` untuk perubahan dokumentasi
- `refactor/` untuk refactoring code

### 4. Setup Development Environment

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed --class=DummyDataSeeder

# Build assets
npm run dev
```

### 5. Buat Perubahan

- Tulis code yang clean dan readable
- Ikuti coding standards Laravel
- Tambahkan komentar jika diperlukan
- Test perubahan Anda

### 6. Commit Perubahan

```bash
git add .
git commit -m "feat: menambahkan fitur X"
```

Gunakan conventional commits:
- `feat:` untuk fitur baru
- `fix:` untuk bug fix
- `docs:` untuk dokumentasi
- `style:` untuk formatting
- `refactor:` untuk refactoring
- `test:` untuk testing
- `chore:` untuk maintenance

### 7. Push ke Fork Anda

```bash
git push origin feature/nama-fitur-anda
```

### 8. Buat Pull Request

1. Buka repository Anda di GitHub
2. Klik "New Pull Request"
3. Pilih branch yang ingin di-merge
4. Isi deskripsi PR dengan detail:
   - Apa yang diubah
   - Kenapa diubah
   - Screenshot (jika ada perubahan UI)
   - Testing yang sudah dilakukan

## 🎯 Area Kontribusi

Kami menerima kontribusi di berbagai area:

### 🐛 Bug Fixes
- Perbaikan bug yang ada
- Perbaikan typo
- Perbaikan error handling

### ✨ New Features
- Fitur baru yang berguna
- Improvement UI/UX
- Optimasi performa

### 📚 Documentation
- Perbaikan dokumentasi
- Menambah tutorial
- Translate dokumentasi

### 🧪 Testing
- Menambah unit tests
- Menambah integration tests
- Improve test coverage

## 📝 Coding Standards

### PHP/Laravel

- Ikuti [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)
- Gunakan Laravel best practices
- Gunakan Eloquent ORM, hindari raw queries
- Gunakan type hints untuk parameter dan return types

### JavaScript

- Gunakan ES6+ syntax
- Gunakan `const` dan `let`, hindari `var`
- Gunakan arrow functions
- Tambahkan komentar untuk logic yang kompleks

### Blade Templates

- Gunakan Blade components jika memungkinkan
- Escape output dengan `{{ }}` untuk keamanan
- Gunakan `@` directives untuk control structures

### CSS

- Gunakan class names yang descriptive
- Hindari inline styles jika memungkinkan
- Gunakan responsive design

## 🧪 Testing

Sebelum submit PR, pastikan:

- [ ] Code berjalan tanpa error
- [ ] Tidak ada breaking changes
- [ ] UI responsive di mobile, tablet, desktop
- [ ] Test manual semua fitur yang diubah
- [ ] Tidak ada console errors

## 📋 Pull Request Checklist

- [ ] Code mengikuti coding standards
- [ ] Commit messages jelas dan descriptive
- [ ] Dokumentasi sudah diupdate (jika perlu)
- [ ] Tidak ada conflict dengan branch main
- [ ] PR description lengkap dan jelas
- [ ] Screenshot disertakan (untuk perubahan UI)

## ❓ Pertanyaan?

Jika ada pertanyaan, silakan:
- Buat [Issue](https://github.com/mukhlish20/Warung-App/issues)
- Diskusi di [Discussions](https://github.com/mukhlish20/Warung-App/discussions)

## 🙏 Terima Kasih!

Setiap kontribusi, sekecil apapun, sangat berarti untuk project ini. Terima kasih telah membantu membuat Warung App lebih baik!

---

**Happy Contributing! 🚀**

