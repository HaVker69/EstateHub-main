<?php

namespace Database\Seeders;

use App\Enums\PropertyStatus;
use App\Enums\ViewingStatus;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class ViewingSeeder extends Seeder
{
    public function run(): void
    {
        $properties = Property::where('status', PropertyStatus::Approved)->get();
        $users = User::whereDoesntHave('roles', fn ($q) => $q->where('name', 'admin'))->get();

        foreach ($properties->random(min(12, $properties->count())) as $property) {
            $requester = $users->where('id', '!=', $property->user_id)->random();

            $property->viewings()->create([
                'user_id' => $requester->id,
                'scheduled_at' => fake()->dateTimeBetween('now', '+3 weeks'),
                'status' => fake()->randomElement(ViewingStatus::cases()),
                'notes' => fake()->optional()->sentence(),
            ]);
        }
    }
}
