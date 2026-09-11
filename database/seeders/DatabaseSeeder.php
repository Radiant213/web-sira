<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Complaint;
use App\Models\Due;
use App\Models\LetterRequest;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'], [
            'description' => 'Administrator utama dengan akses penuh ke seluruh modul RT/RW'
        ]);
        $wargaRole = Role::firstOrCreate(['name' => 'warga', 'guard_name' => 'web'], [
            'description' => 'Akun warga lingkungan RT/RW untuk layanan surat, pengaduan, dan iuran'
        ]);
        $bendaharaRole = Role::firstOrCreate(['name' => 'bendahara', 'guard_name' => 'web'], [
            'description' => 'Pengurus bagian keuangan dan pembukuan kas iuran warga'
        ]);
        $sekretarisRole = Role::firstOrCreate(['name' => 'sekretaris', 'guard_name' => 'web'], [
            'description' => 'Pengurus bagian persuratan dan administrasi kependudukan'
        ]);

        // 2. Admin Utama
        $admin = User::firstOrCreate(
            ['email' => 'admin@sira.test'],
            [
                'nik' => '3201010101900001',
                'name' => 'Admin RT 01',
                'phone' => '081234567890',
                'address' => 'Jl. Komp. Melati No. 01, RT 001/RW 002',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);

        // 3. Warga Terverifikasi 1 (Akun Uji Coba Utama)
        $warga1 = User::firstOrCreate(
            ['email' => 'warga@sira.test'],
            [
                'nik' => '3201012345678901',
                'name' => 'Budi Santoso',
                'phone' => '081298765432',
                'address' => 'Jl. Komp. Melati No. 12, RT 001/RW 002',
                'password' => bcrypt('password'),
                'role' => 'warga',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );
        $warga1->assignRole($wargaRole);

        // 4. Warga Terverifikasi 2
        $warga2 = User::firstOrCreate(
            ['email' => 'siti@sira.test'],
            [
                'nik' => '3201019876543210',
                'name' => 'Siti Rahmawati',
                'phone' => '081387654321',
                'address' => 'Jl. Komp. Melati No. 08, RT 001/RW 002',
                'password' => bcrypt('password'),
                'role' => 'warga',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );
        $warga2->assignRole($wargaRole);

        // 5. Warga Pending (Untuk demo verifikasi admin)
        $wargaPending = User::firstOrCreate(
            ['email' => 'wargabaru@sira.test'],
            [
                'nik' => '3201015555555555',
                'name' => 'Ahmad Fauzi (Warga Baru)',
                'phone' => '085712345678',
                'address' => 'Jl. Komp. Melati Blok C No. 05, RT 001/RW 002',
                'password' => bcrypt('password'),
                'role' => 'warga',
                'is_verified' => false,
                'email_verified_at' => now(),
            ]
        );
        $wargaPending->assignRole($wargaRole);

        // 6. Permohonan Surat Pengantar (Letter Requests)
        LetterRequest::firstOrCreate(
            ['user_id' => $warga1->id, 'letter_type' => 'Surat Keterangan Domisili'],
            [
                'purpose' => 'Keperluan pembukaan rekening tabungan bank dan registrasi NPWP',
                'status' => 'approved',
                'created_at' => now()->subDays(5),
            ]
        );

        LetterRequest::firstOrCreate(
            ['user_id' => $warga1->id, 'letter_type' => 'Surat Pengantar SKCK'],
            [
                'purpose' => 'Persyaratan berkas melamar pekerjaan di instansi BUMN',
                'status' => 'pending',
                'created_at' => now()->subDays(1),
            ]
        );

        LetterRequest::firstOrCreate(
            ['user_id' => $warga2->id, 'letter_type' => 'Surat Keterangan Usaha (SKU)'],
            [
                'purpose' => 'Pengajuan bantuan modal UMKM tingkat kecamatan',
                'status' => 'rejected',
                'rejection_reason' => 'Mohon lampirkan foto fisik tempat usaha dan kartu keluarga terbaru.',
                'created_at' => now()->subDays(3),
            ]
        );

        // 7. Pengaduan Lingkungan (Complaints)
        Complaint::firstOrCreate(
            ['user_id' => $warga1->id, 'title' => 'Lampu Penerangan Jalan Gang 2 Mati'],
            [
                'description' => 'Lampu PJU di tiang listrik depan rumah nomor 10 sudah padam 3 malam berturut-turut sehingga jalan sangat gelap saat malam.',
                'status' => 'process',
                'admin_response' => 'Terima kasih atas laporannya. Tim seksi keamanan dan sarana sudah menghubungi petugas PLN untuk penggantian bohlam besok pagi.',
                'created_at' => now()->subDays(2),
            ]
        );

        Complaint::firstOrCreate(
            ['user_id' => $warga2->id, 'title' => 'Saluran Air / Selokan Tersumbat Pasca Hujan'],
            [
                'description' => 'Gorong-gorong di tikungan RT 01 meluap akibat sampah daun dan lumpur sisa hujan deras.',
                'status' => 'resolved',
                'admin_response' => 'Sudah ditindaklanjuti dan dibersihkan bersama warga saat kerja bakti hari Minggu kemarin. Aliran air kembali lancar.',
                'created_at' => now()->subDays(7),
            ]
        );

        Complaint::firstOrCreate(
            ['user_id' => $warga1->id, 'title' => 'Jadwal Pengangkutan Sampah Terlambat'],
            [
                'description' => 'Truk sampah biasanya datang hari Selasa dan Jumat, minggu ini baru datang hari Sabtu sehingga bak sampah penuh.',
                'status' => 'pending',
                'created_at' => now()->subHours(6),
            ]
        );

        // 8. Iuran Kas Bulanan (Dues) - format YYYY-MM (max 7 chars)
        Due::firstOrCreate(
            ['user_id' => $warga1->id, 'month_year' => '2026-01'],
            [
                'amount' => 50000,
                'status' => 'paid',
                'payment_date' => now()->subMonths(2),
            ]
        );

        Due::firstOrCreate(
            ['user_id' => $warga1->id, 'month_year' => '2026-02'],
            [
                'amount' => 50000,
                'status' => 'paid',
                'payment_date' => now()->subMonth(),
            ]
        );

        Due::firstOrCreate(
            ['user_id' => $warga1->id, 'month_year' => '2026-03'],
            [
                'amount' => 50000,
                'status' => 'unpaid',
            ]
        );

        Due::firstOrCreate(
            ['user_id' => $warga2->id, 'month_year' => '2026-01'],
            [
                'amount' => 50000,
                'status' => 'paid',
                'payment_date' => now()->subMonths(2),
            ]
        );

        Due::firstOrCreate(
            ['user_id' => $warga2->id, 'month_year' => '2026-02'],
            [
                'amount' => 50000,
                'status' => 'unpaid',
            ]
        );
    }
}
