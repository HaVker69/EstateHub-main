<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin EstateHub',
            'email' => 'admin@estatehub.test',
            'phone' => '+381 60 111 2222',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole(RoleName::Admin->value);

        $members = [
            ['name' => 'Kristina Arsenijević', 'email' => 'kristina@estatehub.test'],
            ['name' => 'Miloš Stevanović', 'email' => 'milos@estatehub.test'],
            ['name' => 'Predrag Krsmanović', 'email' => 'predrag@estatehub.test'],
        ];

        foreach ($members as $member) {
            $user = User::create([
                'name' => $member['name'],
                'email' => $member['email'],
                'phone' => fake()->phoneNumber(),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]);
            $user->assignRole(RoleName::User->value);
        }

        User::factory(15)->create()->each(function (User $user) {
            $user->assignRole(RoleName::User->value);
        });
    }
}
