<?php

namespace Tests\Feature;

use App\Enums\PropertyStatus;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PropertyModerationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::findOrCreate('user', 'web');
        Role::findOrCreate('admin', 'web');
    }

    public function test_new_listing_from_registered_user_starts_as_pending(): void
    {
        $owner = User::factory()->create();
        $owner->assignRole('user');
        $type = \App\Models\PropertyType::factory()->create();

        $this->actingAs($owner)->post(route('properties.store'), [
            'property_type_id' => $type->id,
            'title' => 'Prelep stan u centru',
            'description' => str_repeat('Odličan opis nekretnine. ', 3),
            'price' => 1000,
            'area' => 50,
            'rooms' => 2,
            'city' => 'Beograd',
            'address' => 'Knez Mihailova 1',
        ]);

        $this->assertDatabaseHas('properties', [
            'title' => 'Prelep stan u centru',
            'status' => PropertyStatus::Pending->value,
        ]);
    }

    public function test_regular_user_cannot_access_admin_moderation(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user)->get(route('admin.properties.index'))->assertForbidden();
    }

    public function test_admin_can_approve_a_pending_property(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $property = Property::factory()->pending()->create();

        $this->actingAs($admin)->patch(route('admin.properties.approve', $property));

        $this->assertEquals(PropertyStatus::Approved, $property->fresh()->status);
    }
}
