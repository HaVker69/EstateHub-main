<?php

namespace Tests\Feature;

use App\Enums\PropertyStatus;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyBrowsingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_browse_approved_properties(): void
    {
        $approved = Property::factory()->create(['status' => PropertyStatus::Approved]);
        $pending = Property::factory()->pending()->create();

        $response = $this->get(route('properties.index'));

        $response->assertOk();
        $response->assertSee($approved->title);
        $response->assertDontSee($pending->title);
    }

    public function test_guest_cannot_view_pending_property_detail(): void
    {
        $pending = Property::factory()->pending()->create();

        $this->get(route('properties.show', $pending))->assertNotFound();
    }
}
