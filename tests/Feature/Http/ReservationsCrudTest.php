<?php

namespace Tests\Feature\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ReservationsCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testGetReservationsCreateRouteReturnsView()
    {
        $this->asUser()->get('reservations/create')->assertViewIs('reservations.create');
    }

    public function testReservationsCrudRoutesRequiresAuthentication()
    {
        $this->get('reservations/create')->assertRedirect('login');
        $this->get('reservations/1')->assertRedirect('login');
        $this->get('reservations/1/edit')->assertRedirect('login');
        $this->post('reservations', [])->assertRedirect('login');
        $this->put('reservations/1', [])->assertRedirect('login');
        $this->delete('reservations/1', [])->assertRedirect('login');
    }

    public function testPostReservationsStoreRouteInsertsReservationOnDb()
    {
        Event::fake([\App\Events\ReservationCreated::class]);

        $vehicle = \App\Models\Vehicle::factory()->create();
        $user = \App\Models\User::factory()->create();
        $reserveDate = now()->addDays(2)->format('Y-m-d');

        $reservation = \App\Models\Reservation::factory()->make([
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
            'date' => $reserveDate
        ]);

        $this->asUser()->post('reservations', $reservation->toArray())
            ->assertSessionHas(['status' => __("Reservation created successfully.")]);

        $this->assertDatabaseHas('reservations', [
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
            'date' => $reserveDate
        ]);

        Event::assertDispatched(\App\Events\ReservationCreated::class, 1);
    }

    public function testPostReservationsStoreRouteValidation()
    {
        $this->asUser()->post('reservations', [])
            ->assertSessionHasErrors(['vehicle_id', 'user_id', 'date']);

        $this->asUser()->post('reservations', [
            'vehicle_id' => 999,
            'user_id' => 999,
            'date' => '1990-01',
        ])->assertSessionHasErrors([
            'vehicle_id' => "The selected vehicle id is invalid.",
            'user_id' => "The selected user id is invalid.",
            'date' => "The date does not match the format Y-m-d.",
        ]);

        $this->asUser()->post('reservations', [
            'date' => '1990-01-01',
        ])->assertSessionHasErrors([
            'date' => "The date must be a date after or equal to today.",
        ]);

        $reservation = \App\Models\Reservation::factory()->create();

        $this->asUser()->post('reservations', $reservation->toArray())
            ->assertSessionHasErrors([
                'date' => "The date has already been taken.",
            ]);
    }

    public function testGetReservationsIndexRouteListReservations()
    {
        $reservations = \App\Models\Reservation::factory()->times(20)->create();

        $this->asUser()->get('reservations')
            ->assertSee($reservations->get(0)->formated_date)
            ->assertSee($reservations->get(1)->formated_date)
            ->assertSee($reservations->get(2)->formated_date)
            ->assertSee('?page=2');
    }

    public function testGetReservationsShowRouteShowsAReservation()
    {
        $this->withoutExceptionHandling();
        $reservation = \App\Models\Reservation::factory()->create();

        $this->asUser()->get("reservations/{$reservation->id}")
            ->assertViewIs('reservations.show')
            ->assertViewHas(['reservation'])
            ->assertSee($reservation->formated_date);
    }

    public function testGetReservationsEditRouteReturnsView()
    {
        $reservation = \App\Models\Reservation::factory()->create();

        $this->asUser()->get("reservations/{$reservation->id}/edit")
            ->assertViewIs('reservations.edit')
            ->assertViewHas(['reservation'])
            ->assertSee($reservation->formated_date);
    }

    public function testPutReservationUpdateRouteUpdatesReservationOnDb()
    {
        Event::fake([\App\Events\ReservationUpdated::class]);

        $reservation = \App\Models\Reservation::factory()->create();

        $this->asUser()->put("reservations/{$reservation->id}", [
            'user_id' => $reservation->user_id,
            'vehicle_id' => $reservation->vehicle_id,
            'date' => now()->addDays(5)->format('Y-m-d')
        ])->assertRedirect(route('reservations.show', [$reservation]))
            ->assertSessionHas(['status' => __("Reservation updated successfully.")]);

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'vehicle_id' => $reservation->vehicle_id,
            'date' => now()->addDays(5)->format('Y-m-d')
        ]);

        Event::assertDispatched(\App\Events\ReservationUpdated::class, 1);
    }

    public function testPutReservationsUpdateRouteValidation()
    {
        $reservation = \App\Models\Reservation::factory()->create();

        $this->asUser()->put("reservations/{$reservation->id}", [])
            ->assertSessionHasErrors(['vehicle_id', 'user_id', 'date']);

        $this->asUser()->put("reservations/{$reservation->id}", [
            'vehicle_id' => 999,
            'user_id' => 999,
            'date' => '1990-01',
        ])->assertSessionHasErrors([
            'vehicle_id' => "The selected vehicle id is invalid.",
            'user_id' => "The selected user id is invalid.",
            'date' => "The date does not match the format Y-m-d.",
        ]);

        $this->asUser()->put("reservations/{$reservation->id}", [
            'date' => '1990-01-01',
        ])->assertSessionHasErrors([
            'date' => "The date must be a date after or equal to today.",
        ]);

        $this->asUser()->put("reservations/{$reservation->id}", $reservation->toArray())
            ->assertSessionHasNoErrors();
    }

    public function testDeleteReservationRouteRemovesReservationFromDb()
    {
        $reservation = \App\Models\Reservation::factory()->create();

        $this->asUser()->delete("reservations/{$reservation->id}", [])
            ->assertRedirect('reservations')
            ->assertSessionHas(['status' => __("Reservation deleted successfully.")]);

        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);
    }
}
