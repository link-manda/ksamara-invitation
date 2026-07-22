<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'package_id' => Package::factory(),
            'xendit_invoice_id' => fake()->unique()->uuid(),
            'amount' => fake()->numberBetween(150_000, 1_500_000),
            'status' => OrderStatus::Pending,
        ];
    }

    public function paid(): static
    {
        return $this->state(fn () => ['status' => OrderStatus::Paid]);
    }
}
