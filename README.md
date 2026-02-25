<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo">
  
  # 📚 Pena Pustaka 
  **Sistem Informasi Perpustakaan Digital Modern**

  Project Uji Kompetensi Keahlian (UKK) - Rekayasa Perangkat Lunak (RPL)

  [![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
  [![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
  [![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
</div>

---

## 📖 Tentang Project
**Pena Pustaka** adalah aplikasi manajemen perpustakaan digital berbasis web yang dikembangkan untuk mempermudah sirkulasi peminjaman buku di sekolah. Dibangun dengan fokus pada antarmuka yang modern (UI) dan pengalaman pengguna yang mulus (UX) menggunakan **Tailwind CSS** dan interaktivitas **Alpine.js**.

Aplikasi ini tidak hanya mencatat peminjaman, tetapi juga memiliki alur kerja (*workflow*) persetujuan pengembalian yang adil, perhitungan denda otomatis, dan sistem ulasan buku.

---

## ✨ Fitur Unggulan

### 👨‍💻 Panel Admin (Petugas)
* **Manajemen Data Induk:** CRUD data Buku, Kategori, dan Anggota (Siswa) dengan validasi relasi data yang aman.
* **Sirkulasi Cerdas:** Mengelola peminjaman dan pengembalian dengan sistem *3-Tabs Workflow* (Sedang Dipinjam, Menunggu Validasi, Riwayat).
* **Validasi Pengembalian:** Memverifikasi pengembalian dari siswa, mengecek kondisi fisik buku (Baik/Rusak/Hilang), dan memproses denda keterlambatan secara otomatis.
* **Manajemen Stok Real-time:** Stok buku otomatis berkurang saat dipinjam dan bertambah saat dikembalikan.

### 🎓 Panel Siswa (Anggota)
* **Katalog Interaktif:** Pencarian buku dan filter kategori dengan tampilan *Grid Card* yang responsif.
* **Peminjaman Mandiri:** Mengajukan peminjaman buku langsung dari katalog.
* **Pengembalian "Stop the Clock":** Mengajukan pengembalian secara mandiri dari dashboard untuk menghentikan perhitungan waktu denda, menunggu verifikasi fisik oleh admin.
* **Sistem Ulasan (Rating):** Memberikan bintang (1-5) dan komentar pada buku yang telah selesai dibaca (Logika: 1 Buku = 1 Ulasan per Siswa).

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** [Laravel](https://laravel.com/) (PHP Framework)
* **Frontend:** Blade Templating, [Tailwind CSS](https://tailwindcss.com/) (Styling), [Alpine.js](https://alpinejs.dev/) (DOM Manipulation & Modals)
* **Database:** MySQL
* **Icons:** Bootstrap Icons

---

## 🚀 Panduan Instalasi (Setup Lokal)

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer Anda.

### Persyaratan Sistem
* PHP >= 8.1
* Composer
* Node.js & NPM
* MySQL / MariaDB

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/nyomangedewisaya/pena-pustaka.git
   ```

2. **Install Dependensi PHP**
   ```bash
   composer install
   ```

3. **Setup Environment File**
   Duplikat file .env.example menjadi .env, lalu konfigurasi koneksi database Anda.
   ```bash
   cp .env.example .env
   ```

   Buka `.env` dan sesuaikan:
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pena_pustaka
   DB_USERNAME=root
   DB_PASSWORD=    # sesuaikan jika ada password
   ```

4. **Generate Application Key**
   ```bash
   php artisan generate:key
   ```
   
5. **Migrasi Database & Seeding (Data Dummy)**
   ```bash
   php artisan migrate --seed
   ```

6. **Link Storage (Untuk Gambar Cover Buku)**
   ```bash
   php artisan storage:link
   ```

7. **Install Dependensi Frontend & Compile Assets**
   ```bash
   npm install
   npm run build
   ```

8. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses pada `http://localhost:8000`.

## 🔐 Akun Default (Testing)

Gunakan kredensial berikut untuk masuk ke dalam sistem setelah menjalankan *Seeder*:

| Role | Username | Password |
| :--- | :--- | :--- |
| **Admin** | `admin-penpus` | `admin1234` |

> **Catatan:** Pastikan Anda menyesuaikan data seeder jika menggunakan kredensial yang berbeda dan untuk student anda wajib registrasi terlebih dahulu.

---

## 🧑‍💻 Pengembang

Dikembangkan oleh **Nyoman Gede Wisaya** sebagai syarat kelulusan Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak Tahun 2026.

* **Asal Sekolah:** SMKS Pangudi Luhur Seputih Mataram
* **GitHub:** `https://github.com/nyomangedewisaya`

<br>

<p align="center">Dibuat dengan ❤️ dan ☕ di Indonesia</p>
