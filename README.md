# 🛒 Aplikasi Web Penjualan Produk – Tugas Akhir JWD Digitalent

Proyek ini merupakan hasil dari tugas akhir pelatihan **Junior Web Developer (JWD)** dari Digitalent Kominfo. Aplikasi ini adalah **simulasi toko online** yang memungkinkan pengguna untuk melihat produk, melakukan pemesanan, serta mengelola data melalui admin panel.

---

## 🎯 Tujuan Proyek

- Menerapkan kemampuan membuat aplikasi web dengan **PHP dan MySQL**
- Memahami konsep **session, cookie, dan autentikasi pengguna**
- Membuat sistem e-commerce sederhana untuk pembelajaran

---

## 🚀 Fitur Aplikasi

### 👤 Fitur Pengguna

- Registrasi dan login
- Login otomatis dengan cookie "Ingat Saya"
- Lihat daftar produk
- Lakukan pemesanan produk
- Lihat dan ubah status pesanan
- Edit profil dan password

### 🛠️ Fitur Admin Panel

- Login admin terpisah
- Dashboard admin (jumlah produk, kategori, pemesanan)
- Tambah, ubah, dan hapus kategori
- Tambah, ubah, dan hapus produk (dengan upload gambar)
- Konfirmasi dan update status pemesanan

---

## 🧰 Teknologi yang Digunakan

| Komponen | Teknologi                    |
| -------- | ---------------------------- |
| Backend  | PHP Native                   |
| Frontend | HTML5, CSS3, Bootstrap 5, JS |
| Database | MySQL                        |
| Auth     | Session & Cookie             |
| Tools    | XAMPP / Laragon              |

---

---

## 💾 Cara Instalasi & Menjalankan

1. **Clone atau Download** repo ini ke dalam folder `htdocs` (XAMPP) atau `www` (Laragon).
2. **Import database** dari file `database.sql` ke phpMyAdmin.
3. Sesuaikan koneksi di `koneksi.php`:
   ```php
   $servername = 'localhost';
   $dbhost = 'root';
   $dbpassword = '';
   $database = 'tugas_akhir';
   ```

## Buka browser dan akses localhost/tugas-akhir-jwd/.

## 🏠 Beranda (Produk)

<img src="image/iqHDEHiDUsjfef.png" width="500"/>

## 📥 Pemesanan Saya

<img src="image/sfsmfkffrvfd.png" width="500"/>

## 🔐 Login Pengguna

<img src="image/jjnushohs.png" width="500"/>

## 👤 Admin Dashboard

<img src="image/svefirjfsiif.png" width="500"/>
