<?php

namespace Database\Seeders;

use App\Enums\PropertyStatus;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        $properties = Property::where('status', PropertyStatus::Approved)->get();
        $users = User::whereDoesntHave('roles', fn ($q) => $q->where('name', 'admin'))->get();

        foreach ($properties->random(min(15, $properties->count())) as $property) {
            $sender = $users->where('id', '!=', $property->user_id)->random();

            $property->inquiries()->create([
                'user_id' => $sender->id,
                'message' => fake()->paragraph(),
            ]);
        }
    }
}
