<?php

namespace Database\Factories;

use App\Models\LetterRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LetterRequest>
 */
class LetterRequestFactory extends Factory
{
    protected $model = LetterRequest::class;

    public function definition(): array
    {
        $types = ['Pengantar KTP', 'Pengantar SKCK', 'Pengantar Kelahiran', 'Pengantar Kematian', 'Pengantar Pindah', 'Keterangan Domisili', 'Keterangan Tidak Mampu'];
        $purposes = [
            'Untuk keperluan pembuatan KTP baru',
            'Untuk keperluan melamar pekerjaan',
            'Untuk keperluan pendaftaran sekolah anak',
            'Untuk keperluan administrasi kelurahan',
            'Untuk keperluan pengurusan dokumen di kecamatan',
            'Untuk keperluan pengajuan bantuan sosial',
            'Untuk keperluan pembuatan SIM baru',
        ];

        return [
            'user_id' => User::factory(),
            'letter_type' => fake()->randomElement($types),
            'purpose' => fake()->randomElement($purposes),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            'rejection_reason' => null,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn () => ['status' => 'pending']);
    }

    public function approved(): static
    {
        return $this->state(fn () => ['status' => 'approved']);
    }

    public function rejected(): static
    {
        return $this->state(fn () => [
            'status' => 'rejected',
            'rejection_reason' => 'Data tidak lengkap, silakan ajukan ulang dengan melampirkan dokumen yang diperlukan.',
        ]);
    }
}
