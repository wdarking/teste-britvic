<?php

namespace Tests\Feature\Listeners;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class LogReservationTest extends TestCase
{
    use RefreshDatabase;

    public function testItRunsHandleMethodOnReservationCreatedEvent()
    {
        $listener = Mockery::spy(\App\Listeners\LogReservation::class);

        $this->instance(\App\Listeners\LogReservation::class, $listener);

        $reservation = \App\Models\Reservation::factory()->create();

        event(new \App\Events\ReservationCreated($reservation));

        $listener->shouldHaveReceived('handle');
    }

    public function testItRunsHandleMethodOnReservationUpdatedEvent()
    {
        $listener = Mockery::spy(\App\Listeners\LogReservation::class);

        $this->instance(\App\Listeners\LogReservation::class, $listener);

        $reservation = \App\Models\Reservation::factory()->create();

        event(new \App\Events\ReservationUpdated($reservation));

        $listener->shouldHaveReceived('handle');
    }
}
