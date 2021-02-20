<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vehicle_id' => \App\Models\Vehicle::factory()->create()->id,
            'user_id' => \App\Models\User::factory()->create()->id,
            'date' => now()->addDays($this->faker->randomNumber(1))->format('Y-m-d'),
        ];
    }
}
