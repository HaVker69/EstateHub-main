<?php

namespace Database\Factories;

use App\Enums\ViewingStatus;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Viewing>
 */
class ViewingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'user_id' => User::factory(),
            'scheduled_at' => fake()->dateTimeBetween('now', '+2 weeks'),
            'status' => fake()->randomElement(ViewingStatus::cases()),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
