<?php

namespace Database\Factories;

use App\Enums\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    protected array $cities = [
        'Beograd', 'Novi Sad', 'Niš', 'Kragujevac', 'Subotica', 'Zrenjanin', 'Čačak', 'Kraljevo',
    ];

    public function definition(): array
    {
        $title = ucfirst(fake()->words(3, true));

        return [
            'user_id' => User::factory(),
            'property_type_id' => PropertyType::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::random(6),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->numberBetween(300, 5000) * 100,
            'area' => fake()->numberBetween(20, 300),
            'rooms' => fake()->numberBetween(1, 6),
            'city' => fake()->randomElement($this->cities),
            'address' => fake()->streetAddress(),
            'status' => PropertyStatus::Approved,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PropertyStatus::Pending,
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PropertyStatus::Rejected,
            'rejection_reason' => fake()->sentence(),
        ]);
    }
}
