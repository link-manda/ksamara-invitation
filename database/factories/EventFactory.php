<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invitation_id' => Invitation::factory(),
            'name' => fake()->randomElement(['Pawiwahan', 'Resepsi', 'Mepamit']),
            'start_time' => fake()->dateTimeBetween('+1 week', '+6 months'),
            'end_time' => null,
            'location_name' => fake()->company(),
            'location_address' => fake()->address(),
            'google_maps_link' => null,
        ];
    }
}
