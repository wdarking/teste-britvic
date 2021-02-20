<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

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
