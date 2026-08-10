<?php

namespace Database\Factories;

use App\Models\Due;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Due>
 */
class DueFactory extends Factory
{
    protected $model = Due::class;

    public function definition(): array
    {
        $isPaid = fake()->boolean(60);

        return [
            'user_id' => User::factory(),
            'month_year' => now()->subMonths(fake()->numberBetween(0, 6))->format('Y-m'),
            'amount' => fake()->randomElement([25000, 50000, 75000, 100000]),
            'status' => $isPaid ? 'paid' : 'unpaid',
            'payment_date' => $isPaid ? fake()->dateTimeBetween('-3 months', 'now') : null,
        ];
    }
}
