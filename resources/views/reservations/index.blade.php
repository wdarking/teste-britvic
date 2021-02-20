@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="card">
            <div class="card-header">
                {{ __('Reservations') }}
                <div class="float-right">
                    <a href="{{ route('reservations.create') }}" class="btn btn-sm btn-primary">{{ __("Add Reservation") }}</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __("Customer") }}</th>
                                <th scope="col">{{ __("Reservation Date") }}</th>
                                <th scope="col">{{ __("Vehicle") }}</th>
                                <th scope="col">{{ __("Actions") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                            <tr>
                                <th scope="row">{{ $reservation->id }}</th>
                                <td>{{ $reservation->user->name }}</td>
                                <td>{{ $reservation->formated_date }}</td>
                                <td>
                                    {{ $reservation->vehicle->name }} | <a href="{{ route('vehicles.show', [$reservation->vehicle]) }}" target="_blank">{{ $reservation->vehicle->license_plate }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('reservations.show', [$reservation]) }}" class="btn btn-sm btn-primary">{{ __('View') }}</a>
                                    <a href="{{ route('reservations.edit', [$reservation]) }}" class="btn btn-sm btn-secondary">{{ __('Edit') }}</a>
                                    <a href="{{ route('reservations.show', [$reservation, 'delete' => 1]) }}" class="btn btn-sm btn-danger">{{ __('Delete') }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="m-2">
                        {{ $reservations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
