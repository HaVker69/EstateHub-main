<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Minimal, idempotent baseline for a real deployment: roles, one admin
 * account, and the property-type taxonomy. No demo users or listings.
 * Safe to run on every container start.
 */
class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $admin = User::firstOrCreate(
            ['email' => 'admin@estatehub.test'],
            [
                'name' => 'Admin EstateHub',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        if (! $admin->hasRole(RoleName::Admin->value)) {
            $admin->assignRole(RoleName::Admin->value);
        }

        $this->call(PropertyTypeSeeder::class);
    }
}
