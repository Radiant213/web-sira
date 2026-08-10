<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil RoleSeeder jika ada, jika tidak, kita bisa abaikan. 
        // Untuk saat ini, kita hanya membuat 1 user Admin utama.

        // Create Admin Utama
        $admin = User::create([
            'nik' => '1234567890123456',
            'name' => 'Admin RT',
            'email' => 'admin@sira.test',
            'phone' => '081234567890',
            'address' => 'Jl. Contoh Alamat No. 1, RT 001/RW 001',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);
    }
}
