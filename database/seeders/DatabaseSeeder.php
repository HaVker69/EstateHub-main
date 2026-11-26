<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PropertyTypeSeeder::class,
            PropertySeeder::class,
            InquirySeeder::class,
            ViewingSeeder::class,
        ]);
    }
}
