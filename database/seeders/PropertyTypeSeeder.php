<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertyTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Stan', 'description' => 'Stanovi u zgradama i stambenim kompleksima'],
            ['name' => 'Kuća', 'description' => 'Porodične kuće i vile'],
            ['name' => 'Poslovni prostor', 'description' => 'Kancelarije, magacini i lokali'],
            ['name' => 'Vikendica', 'description' => 'Objekti za odmor van grada'],
            ['name' => 'Plac', 'description' => 'Građevinsko i poljoprivredno zemljište'],
            ['name' => 'Garaža', 'description' => 'Garažna mesta i parking prostori'],
        ];

        foreach ($types as $type) {
            PropertyType::updateOrCreate(
                ['slug' => Str::slug($type['name'])],
                ['name' => $type['name'], 'description' => $type['description']]
            );
        }
    }
}
