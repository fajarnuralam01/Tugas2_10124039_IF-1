# Sistem Manajemen Rutinitas

Tugas 2 

| | |
|---|---|
| Nama | Fajar Nur Alam |
| NIM | 10124039 |
| Kelas | IF-1 |

Aplikasi web sederhana untuk mengelola rutinitas harian, dibuat dengan PHP murni dan MySQL (PDO).

## Fitur

- **CRUD** rutinitas: tambah, tampil, ubah, dan hapus data.
- **Login dan proteksi halaman** memakai `$_SESSION`. Halaman CRUD tidak bisa dibuka tanpa login.
- **Dual bahasa** (Indonesia dan Inggris). Pilihan bahasa disimpan di `$_SESSION`, sehingga konsisten saat pindah halaman.
- **Validasi dan sanitasi input** memakai `htmlspecialchars()` dan if-else.
- **Prepared statement** PDO untuk semua query.

## Struktur Folder

```
Tugas2_10124039_IF-1/
├── sistem_rutinitas/
│   ├── koneksi.php      # koneksi database (PDO)
│   ├── lang.php         # session_start dan kamus dua bahasa
│   ├── login.php        # halaman login
│   ├── logout.php       # menghapus session
│   ├── index.php        # Read: daftar rutinitas
│   ├── create.php       # Create: tambah rutinitas
│   ├── update.php       # Update: ubah rutinitas
│   └── delete.php       # Delete: hapus rutinitas
├── db_rutinitas.sql     # ekspor database
├── laporan_tugas2_10124039.pdf
└── README.md
```

## Kebutuhan

- XAMPP (Apache, MySQL/MariaDB, PHP 8.x)
- Browser
- Koneksi internet (tampilan memakai Bootstrap dari CDN)

## Cara Menjalankan

1. **Unduh proyek.** Klik **Code**, lalu **Download ZIP**, dan ekstrak.
2. **Salin ke XAMPP.** Pindahkan folder `sistem_rutinitas` ke `C:\xampp\htdocs\`.
3. **Nyalakan server.** Buka XAMPP Control Panel, lalu **Start** pada **Apache** dan **MySQL**.
4. **Import database.**
   - Buka `http://localhost/phpmyadmin`.
   - Klik tab **Import**, pilih file `db_rutinitas.sql`, lalu klik **Import**.
   - Database `db_rutinitas` akan terbuat otomatis, lengkap dengan tabel dan data contoh.
5. **Cek koneksi.** Pengaturan bawaan di `koneksi.php`: host `localhost`, user `root`, password kosong. Sesuaikan jika MySQL Anda berbeda.
6. **Buka aplikasi.** Akses `http://localhost/sistem_rutinitas/login.php`.

## Akun Login

| Username | Password |
|---|---|
| admin | iniadmin |

## Alur Singkat

1. Pengguna login. Jika berhasil, `$_SESSION["username"]` dibuat dan pengguna masuk ke `index.php`.
2. Dari daftar rutinitas, pengguna bisa menambah, mengubah, atau menghapus data.
3. Tautan **ID | EN** mengganti bahasa, disimpan di `$_SESSION["lang"]`.
4. Tombol **Keluar** menghapus session dan kembali ke halaman login.

Penjelasan lengkap dan tangkapan layar ada di `laporan_tugas2_10124039.pdf`.
