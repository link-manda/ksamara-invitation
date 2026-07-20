<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Basic', 'Premium', 'Deluxe']),
            'price' => fake()->numberBetween(150_000, 1_500_000),
            'features' => ['max_gallery' => fake()->numberBetween(5, 50), 'has_qris' => fake()->boolean()],
            'is_active' => true,
        ];
    }
}
