<?php

namespace Tests\Feature\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QueryTest extends TestCase
{
    use RefreshDatabase;

    public function testGetQueryReturnsMonthDays()
    {
        $vehicle = \App\Models\Vehicle::factory()->create();

        $this->asUser()->get("query?year=2020&month=1&vehicle_id={$vehicle->id}")
            ->assertSee('01/01/2020')
            ->assertSee('31/01/2020');
    }
}
