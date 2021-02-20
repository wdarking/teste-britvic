@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="card">
            <div class="card-header">
                {{ __('Reservation: :description', ['description' => $reservation->description]) }}
                <div class="float-right">
                    <div class="btn-group">
                        <a href="{{ route('reservations.edit', [$reservation]) }}"
                            class="btn btn-sm btn-secondary">{{ __("Edit") }}</a>
                        <a href="{{ route('reservations.destroy', [$reservation]) }}" class="btn btn-sm btn-danger"
                            data-toggle="modal" data-target="#deleteReservationModal">
                            {{ __("Delete") }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <ul class="list-group">
                            <li class="list-group-item">{{ __("Vehicle") }}: {{ $reservation->vehicle->name }} | <a href="{{ route('vehicles.show', [$reservation->vehicle]) }}" target="_blank">{{ $reservation->vehicle->license_plate }}</a></li>
                            <li class="list-group-item">{{ __("Customer") }}: {{ $reservation->user->name }} | <a href="">{{ $reservation->user->document }}</a></li>
                            <li class="list-group-item">{{ __("Reservation Date") }}: {{ $reservation->formated_date }}</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Delete Car Modal -->
<div class="modal fade" id="deleteReservationModal" tabindex="-1" aria-labelledby="deleteReservationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteReservationModalLabel">{{ __("Are you sure?") }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __("You are deleting reservation :description (:id). This action is not reversible.", ['description' => $reservation->description, 'id' => $reservation->id]) }}
                </p>
                <form id="deleteCarForm" action="{{ route('reservations.destroy', [$reservation]) }}" method="POST">
                    @csrf
                    @method('delete')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
                <button type="submit" class="btn btn-danger"
                    form="deleteCarForm">{{ __("Yes, delete reservation") }}</button>
            </div>
        </div>
    </div>
</div>

@if(request()->query('delete'))
<script>
    (function() {
        window.onload = function() {
            $('#deleteReservationModal').modal('show')

            $('#deleteReservationModal').on('hidden.bs.modal', function (event) {
                window.location.href = "{{ route('reservations.show', [$reservation]) }}"
            })
        }
    })()
</script>
@endif
@endsection
