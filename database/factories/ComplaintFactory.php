<?php

namespace Database\Factories;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Complaint>
 */
class ComplaintFactory extends Factory
{
    protected $model = Complaint::class;

    public function definition(): array
    {
        $complaints = [
            ['title' => 'Lampu jalan padam', 'description' => 'Lampu jalan di depan Gang Melati sudah padam selama 3 hari. Kondisi jalan menjadi gelap dan berbahaya untuk warga yang lewat pada malam hari.'],
            ['title' => 'Sampah menumpuk', 'description' => 'Tumpukan sampah di TPS dekat balai RT sudah menumpuk dan berbau. Mohon untuk segera dikoordinasikan pengangkutan sampah.'],
            ['title' => 'Saluran air tersumbat', 'description' => 'Saluran air di sepanjang Jl. Kenanga tersumbat sampah sehingga air tidak mengalir dan menyebabkan genangan saat hujan.'],
            ['title' => 'Jalan berlubang', 'description' => 'Ada beberapa lubang besar di jalan utama RT yang sudah beberapa kali menyebabkan pengendara motor terjatuh.'],
            ['title' => 'Pohon tumbang', 'description' => 'Pohon besar di taman RT tumbang setelah hujan deras semalam. Pohon menutupi sebagian jalan dan berbahaya bagi yang lewat.'],
            ['title' => 'Fasilitas umum rusak', 'description' => 'Bangku taman dan papan pengumuman RT kondisinya sudah rusak dan perlu diperbaiki segera.'],
            ['title' => 'Kebisingan malam hari', 'description' => 'Ada kegiatan yang menimbulkan kebisingan setiap malam di sekitar blok C. Warga sekitar merasa terganggu.'],
            ['title' => 'Kucing liar berkeliaran', 'description' => 'Banyak kucing liar yang berkeliaran dan membongkar tempat sampah warga. Mohon solusi untuk mengatasi masalah ini.'],
        ];

        $selected = fake()->randomElement($complaints);

        return [
            'user_id' => User::factory(),
            'title' => $selected['title'],
            'description' => $selected['description'],
            'photo' => null,
            'status' => fake()->randomElement(['pending', 'process', 'resolved']),
            'admin_response' => null,
        ];
    }
}
