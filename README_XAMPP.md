# Niren PHP + XAMPP + MySQL — Versi Aman

## Menjalankan
1. Extract folder `Niren_PHP_XAMPP` ke `C:\xampp\htdocs\`.
2. Start Apache dan MySQL di XAMPP.
3. Buka phpMyAdmin dan import `database.sql`.
4. Buka `http://localhost/Niren_PHP_XAMPP/`.

## Membuat admin dengan aman
Buka sekali:
`http://localhost/Niren_PHP_XAMPP/admin/setup_admin.php`

Keamanan setup:
- hanya bisa diakses dari komputer lokal (`127.0.0.1` / `::1`)
- hanya aktif jika belum ada akun admin
- menggunakan CSRF token
- username divalidasi
- password minimal 12 karakter
- password disimpan menggunakan `password_hash()`
- setelah admin dibuat, file `config/admin_setup.lock` dibuat dan setup otomatis dikunci

Setelah berhasil, gunakan:
`http://localhost/Niren_PHP_XAMPP/admin/login.php`

Tidak perlu menghapus `setup_admin.php` secara manual. Namun, jika project akan dipindahkan ke hosting/public server, disarankan menghapus `admin/setup_admin.php` setelah akun admin dibuat.

## Catatan
Akun admin lama dari versi sebelumnya dengan password `admin123` tidak dibuat oleh setup baru. Jika database lama sudah memiliki akun admin, setup akan terkunci. Untuk mengganti password, gunakan mekanisme pengelolaan admin yang terpisah atau ubah melalui database dengan password hash yang aman.
