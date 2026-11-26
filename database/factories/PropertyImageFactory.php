<?php

namespace Database\Factories;

use App\Models\Property;
use App\Support\PlaceholderImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyImage>
 */
class PropertyImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'path' => PlaceholderImage::generateAndStore('EstateHub'),
            'sort_order' => 0,
        ];
    }
}
