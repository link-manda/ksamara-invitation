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
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create Packages and Templates
        $packages = \App\Models\Package::factory(3)->create();
        $templates = \App\Models\Template::factory(3)->create();

        // Create Orders for the user
        $orders = \App\Models\Order::factory(2)->create([
            'user_id' => $user->id,
            'package_id' => $packages->first()->id,
        ]);

        // Create Invitations and related data
        foreach ($orders as $order) {
            $invitation = \App\Models\Invitation::factory()->create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'template_id' => $templates->first()->id,
            ]);

            \App\Models\Event::factory(2)->create(['invitation_id' => $invitation->id]);
            \App\Models\Gallery::factory(5)->create(['invitation_id' => $invitation->id]);
            \App\Models\DigitalEnvelope::factory(2)->create(['invitation_id' => $invitation->id]);
            \App\Models\Rsvp::factory(5)->create(['invitation_id' => $invitation->id]);
        }
    }
}
