<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyType>
 */
class PropertyTypeFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Stan', 'Kuća', 'Poslovni prostor', 'Vikendica', 'Plac', 'Garaža', 'Lokal',
        ]).' '.fake()->unique()->numberBetween(1, 1000);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
        ];
    }
}
