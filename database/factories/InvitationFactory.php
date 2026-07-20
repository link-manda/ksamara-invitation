<?php

namespace Database\Factories;

use App\Enums\InvitationStatus;
use App\Models\Invitation;
use App\Models\Order;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invitation>
 */
class InvitationFactory extends Factory
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
            'order_id' => Order::factory(),
            'template_id' => Template::factory(),
            'slug' => fake()->unique()->slug(2),
            'title' => fake()->sentence(3),
            'groom_name' => fake()->firstName('male'),
            'bride_name' => fake()->firstName('female'),
            'groom_parents' => fake()->name('male').' & '.fake()->name('female'),
            'bride_parents' => fake()->name('male').' & '.fake()->name('female'),
            'music_path' => null,
            'status' => InvitationStatus::Draft,
        ];
    }
}
