# Security Policy

## 🔒 Supported Versions

Kami saat ini mendukung versi berikut dengan security updates:

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |
| < 1.0   | :x:                |

## 🐛 Reporting a Vulnerability

Kami sangat menghargai laporan keamanan dari komunitas. Jika Anda menemukan vulnerability, mohon **JANGAN** membuat public issue.

### Cara Melaporkan

1. **Email:** Kirim detail vulnerability ke [security@example.com]
2. **Subject:** `[SECURITY] Brief description`
3. **Include:**
   - Deskripsi vulnerability
   - Langkah-langkah untuk reproduce
   - Potential impact
   - Suggested fix (jika ada)

### Response Timeline

- **24 jam:** Kami akan acknowledge laporan Anda
- **7 hari:** Kami akan memberikan assessment awal
- **30 hari:** Kami akan merilis fix (jika confirmed)

### Disclosure Policy

- Kami akan memberitahu Anda ketika fix sudah ready
- Kami akan credit Anda di CHANGELOG (jika Anda mau)
- Mohon tunggu sampai fix dirilis sebelum public disclosure

## 🛡️ Security Best Practices

### Untuk Developers

1. **Never commit sensitive data**
   - API keys
   - Passwords
   - Database credentials
   - Private keys

2. **Always use .env for configuration**
   - Jangan hardcode credentials
   - Gunakan .env.example sebagai template

3. **Validate all inputs**
   - Gunakan Laravel validation
   - Sanitize user inputs
   - Prevent SQL injection

4. **Use HTTPS in production**
   - Force HTTPS
   - Secure cookies
   - HSTS headers

5. **Keep dependencies updated**
   - Regularly run `composer update`
   - Check for security advisories
   - Use `composer audit`

### Untuk Users

1. **Change default credentials**
   - Ganti password default setelah seeding
   - Gunakan password yang kuat

2. **Secure your .env file**
   - Jangan share .env file
   - Set proper file permissions (600)

3. **Regular backups**
   - Backup database secara berkala
   - Simpan backup di tempat yang aman

4. **Monitor logs**
   - Check `storage/logs/laravel.log`
   - Monitor suspicious activities

5. **Update regularly**
   - Update ke versi terbaru
   - Apply security patches

## 🔐 Security Features

Aplikasi ini sudah dilengkapi dengan:

- ✅ **CSRF Protection** - Token CSRF di semua form
- ✅ **Password Hashing** - Bcrypt untuk password
- ✅ **SQL Injection Prevention** - Eloquent ORM
- ✅ **XSS Protection** - Blade escaping
- ✅ **Authentication** - Laravel Auth
- ✅ **Authorization** - Role-based middleware
- ✅ **Input Validation** - Laravel validation rules
- ✅ **Secure Sessions** - Encrypted sessions

## 📚 Resources

- [Laravel Security Documentation](https://laravel.com/docs/security)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Best Practices](https://www.php.net/manual/en/security.php)

## 🙏 Acknowledgments

Kami berterima kasih kepada security researchers yang telah membantu membuat aplikasi ini lebih aman.

---

**Thank you for helping keep Warung App secure!** 🔒

