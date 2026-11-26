<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use App\Support\PlaceholderImage;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $owners = User::whereDoesntHave('roles', fn ($q) => $q->where('name', 'admin'))->get();
        $typeIds = PropertyType::pluck('id');

        Property::factory(30)
            ->recycle($owners)
            ->create([
                'property_type_id' => fn () => $typeIds->random(),
            ])
            ->each(function (Property $property) {
                $property->images()->createMany(
                    collect(range(1, fake()->numberBetween(2, 4)))->map(fn ($i) => [
                        'path' => PlaceholderImage::generateAndStore($property->title),
                        'sort_order' => $i,
                    ])->all()
                );
            });

        Property::factory(6)
            ->pending()
            ->recycle($owners)
            ->create(['property_type_id' => fn () => $typeIds->random()])
            ->each(function (Property $property) {
                $property->images()->create([
                    'path' => PlaceholderImage::generateAndStore($property->title),
                    'sort_order' => 1,
                ]);
            });

        Property::factory(4)
            ->rejected()
            ->recycle($owners)
            ->create(['property_type_id' => fn () => $typeIds->random()])
            ->each(function (Property $property) {
                $property->images()->create([
                    'path' => PlaceholderImage::generateAndStore($property->title),
                    'sort_order' => 1,
                ]);
            });
    }
}
