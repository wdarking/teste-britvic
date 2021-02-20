<?php

namespace Tests\Feature\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarsCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testGetCarsCreateRouteReturnsView()
    {
        $this->asUser()->get('cars/create')->assertViewIs('cars.create');
    }

    public function testCarsCrudRoutesRequiresAuthentication()
    {
        $this->get('cars/create')->assertRedirect('login');
        $this->get('cars/1')->assertRedirect('login');
        $this->get('cars/1/edit')->assertRedirect('login');
        $this->post('cars', [])->assertRedirect('login');
        $this->put('cars/1', [])->assertRedirect('login');
        $this->delete('cars/1', [])->assertRedirect('login');
    }

    public function testPostCarsCreateRouteInsertsCarOnDb()
    {
        $car = \App\Models\Car::factory()->make([
            'name' => 'Porsche Cayman',
            'year' => '1990',
            'model' => 'A11',
            'brand' => 'Porsche',
            'license_plate' => 'ABC123A'
        ]);

        $this->asUser()->post('cars', $car->toArray())
            ->assertSessionHas(['status' => __("Car created successfully.")]);

        $this->assertDatabaseHas('cars', [
            'name' => 'Porsche Cayman',
            'model' => 'A11',
            'brand' => 'Porsche',
            'license_plate' => 'ABC123A',
        ]);
    }

    public function testGetCarsIndexRouteListCars()
    {
        $cars = \App\Models\Car::factory()->times(20)->create();

        $this->asUser()->get('cars')
            ->assertSee($cars->get(0)->name)
            ->assertSee($cars->get(1)->name)
            ->assertSee($cars->get(2)->name)
            ->assertSee('?page=2');
    }

    public function testGetCarsShowRouteShowsACar()
    {
        $car = \App\Models\Car::factory()->create();

        $this->asUser()->get("cars/{$car->id}")
            ->assertViewIs('cars.show')
            ->assertViewHas(['car'])
            ->assertSee($car->name);
    }

    public function testGetCarsEditRouteReturnsView()
    {
        $car = \App\Models\Car::factory()->create();

        $this->asUser()->get("cars/{$car->id}/edit")
            ->assertViewIs('cars.edit')
            ->assertViewHas(['car'])
            ->assertSee($car->name);
    }

    public function testPutCarsUpdateRouteUpdatesCarOnDb()
    {
        $car = \App\Models\Car::factory()->create();

        $this->asUser()->put("cars/{$car->id}", [
            'name' => 'Foo Car',
            'model' => 'Bar',
            'license_plate' => 'RET123'
        ])->assertRedirect(route('cars.show', [$car]))
        ->assertSessionHas(['status' => __("Car updated successfully.")]);

        $this->assertDatabaseHas('cars', [
            'id' => $car->id,
            'name' => 'Foo Car',
            'model' => 'Bar',
            'license_plate' => 'RET123',
        ]);
    }

    public function testDeleteCarsRouteRemovesCarFromDb()
    {
        $car = \App\Models\Car::factory()->create();

        $this->asUser()->delete("cars/{$car->id}", [])
            ->assertRedirect('cars')
            ->assertSessionHas(['status' => __("Car deleted successfully.")]);

        $this->assertDatabaseMissing('cars', ['id' => $car->id]);
    }
}
