<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => implode('', ['Car ', $this->faker->word()]),
            'year' => '1990',
            'model' => implode('', ['Grand ', $this->faker->safeColorName]),
            'brand' => 'Audi',
            'license_plate' => implode('', ['ABC', $this->faker->randomNumber(6)]),
        ];
    }
}
