# SIRA - Sistem Informasi Rukun Tetangga (RT/RW) Digital

<p align="center">
  <img src="public/images/logo-r.jpg" alt="SIRA Logo" width="200" style="border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
</p>

SIRA (Sistem Informasi RT/RW) adalah platform digital berbasis web yang dirancang khusus untuk mempermudah administrasi, komunikasi, dan transparansi antara warga dan pengurus RT/RW. Dibangun dengan framework **Laravel**, SIRA mengusung desain antarmuka yang modern, responsif, dan elegan, serta fungsionalitas yang mumpuni.

---

## 🌟 Fitur Utama

SIRA membagi fiturnya menjadi dua peran (Role) utama, yakni **Admin (Pengurus RT/RW)** dan **Warga**:

### 👨‍💼 Fitur Admin (Pengurus)
- **Dashboard Interaktif**: Statistik jumlah warga, laporan pengaduan, dan grafik pembayaran iuran dalam satu layar.
- **Manajemen Warga**: Pendataan warga (Approval akun baru dengan verifikasi KTP/KK secara manual).
- **Verifikasi Surat Pengantar**: Menyetujui atau menolak permohonan surat pengantar dari warga dan mencetaknya (PDF).
- **Manajemen Iuran**: Mencatat tagihan warga (bulanan), melacak tunggakan, dan memproses pembayaran.
- **Manajemen Pengaduan**: Menerima dan merespons keluhan warga, serta memperbarui status (Menunggu, Diproses, Selesai).
- **Manajemen Role & Akses**: Membuat role *custom* (seperti bendahara/sekretaris) dengan sistem deskripsi fungsi yang jelas.

### 👥 Fitur Warga
- **Portal Registrasi Terpadu**: Pendaftaran akun baru yang aman dengan sistem verifikasi Email berbasis **OTP (One Time Password)**.
- **Dashboard Warga**: Pantauan status surat, notifikasi, dan tagihan iuran aktif.
- **Permohonan Surat**: Mengajukan surat pengantar (Domisili, Tidak Mampu, dsb) tanpa harus datang ke rumah RT.
- **Lapor & Pengaduan**: Saluran komunikasi dua arah untuk melaporkan masalah di lingkungan (Fasilitas rusak, keamanan, dll).
- **Cek Tagihan Iuran**: Transparansi status pembayaran tagihan iuran bulanan.
- **Profil & Keamanan**: Mengubah data diri, update nomor telepon, reset password, dan penggantian email yang divalidasi ulang via OTP.

---

## 🚀 Keunggulan Sistem

1. **OTP Email Verification**: Terintegrasi penuh dengan SMTP Mail untuk validasi kepemilikan email saat mendaftar, ganti email, maupun lupa password.
2. **Modern & Responsive UI/UX**: Menggunakan *Tailwind CSS* dengan gaya komponen *glassmorphism*, border melengkung (*rounded-2xl*), dan animasi mikro yang halus (Alpine.js).
3. **Sistem Notifikasi Pintar**: Notifikasi *real-time* di aplikasi dan via Email untuk setiap pembaruan status (Surat disetujui, Iuran lunas, dsb).
4. **Keamanan Ekstra**: Proteksi berlapis; meski warga lolos OTP email, akun belum bisa digunakan secara penuh sebelum divalidasi dan diaktifkan (Is Verified) oleh Admin.

---

## 💻 Tech Stack

- **Framework Backend**: Laravel 11 (PHP 8.2+)
- **Frontend / Styling**: Blade Templating, Tailwind CSS, Alpine.js
- **Database**: MySQL / MariaDB
- **Autentikasi & Hak Akses**: Laravel Auth & Spatie Permission
- **Email Delivery**: SMTP Gmail (Configured)
- **Asset Bundler**: Vite

---

## 🛠 Panduan Instalasi (Development)

Pastikan sistem Anda sudah terinstal **PHP >= 8.2**, **Composer**, dan **MySQL/MariaDB** (Atau menggunakan Laragon/XAMPP).

1. **Clone repositori ini:**
   ```bash
   git clone https://github.com/username/sira_radiant.git
   cd sira_radiant
   ```

2. **Install dependensi PHP & Node:**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment:**
   Salin file konfigurasi lalu sesuaikan pengaturan *Database* dan *SMTP Mail* Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   **Contoh Konfigurasi Mail (OTP):**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=465
   MAIL_USERNAME=email_anda@gmail.com
   MAIL_PASSWORD=app_password_anda
   MAIL_ENCRYPTION=ssl
   MAIL_FROM_ADDRESS="email_anda@gmail.com"
   MAIL_FROM_NAME="SIRA RT/RW Digital"
   ```

4. **Migrasi dan Seeder (Database):**
   ```bash
   php artisan migrate --seed
   ```
   *(Catatan: Menjalankan seeder akan otomatis membuat akun Admin *default* dan Role bawaan)*

5. **Kompilasi Asset:**
   ```bash
   npm run build
   # atau untuk development: npm run dev
   ```

6. **Jalankan Aplikasi:**
   ```bash
   php artisan serve
   ```
   Akses di: `http://localhost:8000`

---

## 🛡 Akun Demo

Jika Anda menggunakan seeder default:
- **Email Admin:** `admin@sira.test`
- **Password:** `password`

---

<p align="center">
  <i>Dikembangkan dengan ❤️ untuk lingkungan Rukun Tetangga yang lebih modern dan transparan.</i>
</p>
