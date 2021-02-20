<?php

namespace Tests\Feature\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VehiclesCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testGetVehiclesCreateRouteReturnsView()
    {
        $this->asUser()->get('vehicles/create')->assertViewIs('vehicles.create');
    }

    public function testVehiclesCrudRoutesRequiresAuthentication()
    {
        $this->get('vehicles/create')->assertRedirect('login');
        $this->get('vehicles/1')->assertRedirect('login');
        $this->get('vehicles/1/edit')->assertRedirect('login');
        $this->post('vehicles', [])->assertRedirect('login');
        $this->put('vehicles/1', [])->assertRedirect('login');
        $this->delete('vehicles/1', [])->assertRedirect('login');
    }

    public function testPostVehiclesStoreRouteInsertsVehicleOnDb()
    {
        $vehicle = \App\Models\Vehicle::factory()->make([
            'name' => 'Porsche Cayman',
            'year' => '1990',
            'model' => 'A11',
            'brand' => 'Porsche',
            'license_plate' => 'ABC123A'
        ]);

        $this->asUser()->post('vehicles', $vehicle->toArray())
            ->assertSessionHas(['status' => __("Vehicle created successfully.")]);

        $this->assertDatabaseHas('vehicles', [
            'name' => 'Porsche Cayman',
            'model' => 'A11',
            'brand' => 'Porsche',
            'license_plate' => 'ABC123A',
        ]);
    }

    public function testPostVehiclesStoreRouteValidation()
    {
        $this->asUser()->post('vehicles', [])
            ->assertSessionHasErrors(['name', 'year', 'model', 'brand', 'license_plate']);

        \App\Models\Vehicle::factory()->create(['license_plate' => 'ASD123']);

        $data = \App\Models\Vehicle::factory()->make(['license_plate' => 'ASD123'])->toArray();

        $this->asUser()->post('vehicles', $data)
            ->assertSessionHasErrors([
                'license_plate' => "The license plate has already been taken."
            ]);
    }

    public function testGetVehiclesIndexRouteListVehicles()
    {
        $vehicles = \App\Models\Vehicle::factory()->times(20)->create();

        $this->asUser()->get('vehicles')
            ->assertSee($vehicles->get(0)->name)
            ->assertSee($vehicles->get(1)->name)
            ->assertSee($vehicles->get(2)->name)
            ->assertSee('?page=2');
    }

    public function testGetVehiclesShowRouteShowsAVehicle()
    {
        $vehicle = \App\Models\Vehicle::factory()->create();

        $this->asUser()->get("vehicles/{$vehicle->id}")
            ->assertViewIs('vehicles.show')
            ->assertViewHas(['vehicle'])
            ->assertSee($vehicle->name);
    }

    public function testGetVehiclesEditRouteReturnsView()
    {
        $vehicle = \App\Models\Vehicle::factory()->create();

        $this->asUser()->get("vehicles/{$vehicle->id}/edit")
            ->assertViewIs('vehicles.edit')
            ->assertViewHas(['vehicle'])
            ->assertSee($vehicle->name);
    }

    public function testPutVehiclesUpdateRouteUpdatesVehicleOnDb()
    {
        $vehicle = \App\Models\Vehicle::factory()->create();

        $this->asUser()->put("vehicles/{$vehicle->id}", [
            'name' => 'Foo Car',
            'year' => $vehicle->year,
            'model' => 'Bar',
            'brand' => $vehicle->brand,
            'license_plate' => 'RET123'
        ])->assertRedirect(route('vehicles.show', [$vehicle]))
        ->assertSessionHas(['status' => __("Vehicle updated successfully.")]);

        $this->assertDatabaseHas('vehicles', [
            'id' => $vehicle->id,
            'name' => 'Foo Car',
            'model' => 'Bar',
            'license_plate' => 'RET123',
        ]);
    }

    public function testPutVehiclesUpdateRouteValidation()
    {
        \App\Models\Vehicle::factory()->create(['license_plate' => 'QWE123']);

        $vehicle = \App\Models\Vehicle::factory()->create(['license_plate' => 'ASD123']);

        $this->asUser()
            ->put("vehicles/{$vehicle->id}", [])
            ->assertSessionHasErrors(['name', 'year', 'model', 'brand', 'license_plate']);

        $data = \App\Models\Vehicle::factory()->make(['license_plate' => 'QWE123'])->toArray();

        $this->asUser()
            ->put("vehicles/{$vehicle->id}", $data)
            ->assertSessionHasErrors([
                'license_plate' => "The license plate has already been taken."
            ]);
    }

    public function testDeleteVehiclesRouteRemovesVehicleFromDb()
    {
        $vehicle = \App\Models\Vehicle::factory()->create();

        $this->asUser()->delete("vehicles/{$vehicle->id}", [])
            ->assertRedirect('vehicles')
            ->assertSessionHas(['status' => __("Vehicle deleted successfully.")]);

        $this->assertDatabaseMissing('vehicles', ['id' => $vehicle->id]);
    }
}
