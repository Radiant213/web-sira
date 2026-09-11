# SIRA - Sistem Informasi Rukun Tetangga (RT/RW) Digital

<p align="center">
  <img src="public/images/logo-r.jpg" alt="SIRA Logo" width="180" style="border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
</p>

<p align="center">
  <b>SIRA (Sistem Informasi RT/RW Digital)</b> adalah platform tata kelola lingkungan berbasis web yang dirancang untuk mendigitalkan administrasi kependudukan, pengajuan surat pengantar, penanganan aspirasi pengaduan, dan transparansi kas iuran bulanan antara pengurus RT/RW dan warga.
</p>

<p align="center">
  <b>Pengembang:</b> Galang Ma'ruf Sherinian &bull; <b>Kelas:</b> XII PPLG 2 (Absen 17) &bull; <b>Tahun:</b> 2026
</p>

---

## 🌟 Fitur Utama Sistem

SIRA membagi fungsionalitasnya menjadi dua peran utama: **Admin (Pengurus RT/RW)** dan **Warga**:

### 👨‍💼 Modul Administrator (Pengurus RT/RW)
- **Dashboard Analitik:** Statistik jumlah warga, ringkasan permohonan surat pending, laporan pengaduan aktif, dan total penerimaan kas iuran.
- **Manajemen Warga:** Verifikasi manual akun warga baru (Approval KTP/KK), penambahan warga secara langsung, dan edit data kependudukan.
- **Verifikasi Surat Pengantar:** Menyetujui atau menolak permohonan surat warga dengan catatan alasan, serta fitur **Cetak Surat Pengantar Resmi (Format Baku & Standar Arsip)**.
- **Manajemen Pengaduan Lingkungan:** Meninjau laporan keluhan fasilitas warga berfoto bukti, memperbarui status (*Pending &rarr; Diproses &rarr; Selesai*), dan memberikan tanggapan resmi.
- **Manajemen Kas Iuran:** Mencatat pelunasan iuran warga (bulanan), melacak tunggakan, dan fitur otomatisasi **Generate Tagihan Batch** untuk seluruh warga terdaftar.
- **Manajemen User & Role:** Pengaturan hak akses staf pengurus (Admin, Sekretaris, Bendahara) menggunakan RBAC Spatie.

### 👥 Modul Pengguna Warga
- **Portal Registrasi Terpadu:** Pendaftaran mandiri dengan validasi NIK 16 digit dan verifikasi kepemilikan email berbasis **OTP (One Time Password)** 6 digit.
- **Dashboard Warga:** Informasi status pengajuan surat, keluhan yang sedang ditangani, dan tagihan iuran bulan berjalan.
- **Permohonan Surat Online:** Pengajuan surat pengantar (Domisili, SKCK, Usaha, Tidak Mampu) tanpa perlu bertamu fisik ke rumah RT.
- **Lapor & Pengaduan Fasilitas:** Melaporkan isu lingkungan (lampu padam, sampah, jalan rusak) dilengkapi lampiran foto bukti pendukung.
- **Transparansi Kas Iuran:** Memantau riwayat pembayaran kas bulanan yang telah lunas dan tagihan yang masih aktif.
- **Profil & Pengaturan Akun:** Pembaruan nomor kontak, alamat, ganti password, dan perubahan email dengan proteksi OTP.

---

## 🛡 Keamanan Berlapis

1. **Email OTP Verification:** Verifikasi kode 6 digit untuk pendaftaran warga, ubah email, dan lupa kata sandi.
2. **Admin Document Verification:** Akun warga baru berstatus *Pending* dan belum dapat mengakses layanan sebelum berkas NIK/KTP divalidasi oleh pengurus.
3. **Two-Factor Authentication (2FA) Admin:** Akses panel admin diproteksi lapis kedua via kode OTP keamanan.

---

## 💻 Spesifikasi & Tech Stack

- **Framework Backend:** Laravel 11.x (PHP 8.3+)
- **Database:** MySQL 8.0 / MariaDB
- **Frontend & Styling:** Blade Templating, Tailwind CSS v4, Alpine.js
- **Asset Bundler:** Vite
- **Autentikasi & Otorisasi:** Laravel Auth & Spatie Laravel-Permission
- **PDF Engine:** Barryvdh Laravel-DomPDF
- **Environment Lokal:** Laragon / Standalone WAMP

---

## 🛠 Panduan Instalasi & Menjalankan di Komputer Lokal

Pastikan komputer telah terinstal **PHP >= 8.2**, **Composer**, **Node.js (NPM)**, dan **MySQL Server** (direkomendasikan menggunakan suite **Laragon**).

### 1. Clone Repositori
```bash
git clone https://github.com/Radiant213/web-sira.git
cd web-sira
```

### 2. Install Dependensi PHP & Frontend
```bash
composer install
npm install
```

### 3. Konfigurasi File Environment (.env)
Salin file `.env.example` ke `.env`:
```bash
cp .env.example .env
php artisan key:generate
```
Sesuaikan konfigurasi database lokal pada file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_sira
DB_USERNAME=root
DB_PASSWORD=
```
*(Catatan: Setel `MAIL_MAILER=log` untuk pengujian lokal agar semua kode OTP dan email notifikasi tersimpan rapi di file `storage/logs/laravel.log`).*

### 4. Setup Database & Seeder
Buat database baru bernama `db_sira` di MySQL, lalu jalankan migrasi dan seeder otomatis:
```bash
php artisan migrate --seed
```

### 5. Kompilasi Asset Frontend
```bash
npm run build
```

### 6. Jalankan Server Aplikasi
```bash
php artisan serve
```
Akses aplikasi melalui browser di: **`http://127.0.0.1:8000`**

---

## 🔑 Kredensial Akun Uji Coba (Demo)

Setelah menjalankan `php artisan migrate --seed`, Anda dapat langsung mencoba sistem menggunakan akun bawaan berikut:

| Peran | Alamat Email | Password | Keterangan Uji Coba |
| :--- | :--- | :--- | :--- |
| **Administrator RT/RW** | `admin@sira.test` | `password` | Akses penuh dashboard admin. *(Kode 2FA OTP dapat dicek di `storage/logs/laravel.log` atau tabel `users.otp_code`)* |
| **Warga Terverifikasi** | `warga@sira.test` | `password` | Akun warga aktif (Budi Santoso) untuk menguji pengajuan surat, lapor keluhan, dan cek kas iuran. |
| **Warga Baru (Pending)** | `wargabaru@sira.test` | `password` | Untuk mendemonstrasikan halaman warga yang menunggu persetujuan/verifikasi dari admin. |

---

## 📄 Laporan Proyek Lengkap

Dokumen laporan lengkap yang memuat latar belakang, perancangan basis data, analisis hak akses, serta **32 dokumentasi screenshot antarmuka per halaman** tersedia pada file:
👉 **`Laporan_Proyek_SIRA.docx`**

---

<p align="center">
  <i>Dikembangkan oleh <b>Galang Ma'ruf Sherinian</b> &bull; Konsentrasi Keahlian PPLG 2026</i>
</p>
