<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\StoreRequest;
use App\Http\Requests\Reservation\UpdateRequest;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    /**
     * Display a listing of the reservations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::query()
            ->with(['vehicle', 'user'])
            ->latest()
            ->paginate();

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new reservation.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::latest()->get();
        $vehicles = Vehicle::latest()->get();

        return view('reservations.create', compact('users', 'vehicles'));
    }

    /**
     * Store a newly created reservation in storage.
     *
     * @param  \App\Http\Requests\Reservation\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        Reservation::create($request->validated());

        return redirect()->route('reservations.index')
            ->with(['status' => __("Reservation created successfully.")]);
    }

    /**
     * Display the specified reservation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified reservation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);

        $users = User::latest()->get();
        $vehicles = Vehicle::latest()->get();

        return view('reservations.edit', compact('reservation', 'users', 'vehicles'));
    }

    /**
     * Update the specified reservation in storage.
     *
     * @param  \App\Http\Requests\Reservation\UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->fill($request->validated())->update();

        return redirect()->route('reservations.show', [$reservation])
            ->with(['status' => __("Reservation updated successfully.")]);
    }

    /**
     * Remove the specified reservation from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Reservation::findOrFail($id)->delete();

        return redirect()->route('reservations.index')
            ->with(['status' => __("Reservation deleted successfully.")]);
    }
}
