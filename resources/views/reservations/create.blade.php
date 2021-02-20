@extends('layouts.app')

@push('head')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"
    integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g=="
    crossorigin="anonymous" />
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="card">
            <div class="card-header">{{ __('Add Reservation') }}</div>

            <div class="card-body">

                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="reservationVehicle">{{ __("Vehicle") }}</label>
                        <select class="form-control select2 @error('vehicle_id') is-invalid @enderror" name="vehicle_id" id="reservationVehicle">
                            <option value="">{{ __("Choose...") }}</option>
                            @foreach($vehicles as $vehicle)
                            <option @if($vehicle->id == request()->query('vehicle_id')) selected="selected" @endif value="{{ $vehicle->id }}">{{ $vehicle->name }} | {{ $vehicle->year }} |
                                {{ $vehicle->model }} | {{ $vehicle->brand }} | {{ $vehicle->license_plate }}</option>
                            @endforeach
                        </select>
                        @error('vehicle_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="reservationUser">{{ __("User") }}</label>
                        <select class="form-control select2 @error('user_id') is-invalid @enderror" name="user_id" id="reservationUser">
                            <option value="">{{ __("Choose...") }}</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="reservationDate">{{ __("Reservation Date") }}</label>
                        <input type="text" class="form-control datetimepicker @error('date') is-invalid @enderror"
                            id="reservationDate" name="date">
                        @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="float-right">
                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">{{ __("Back") }}</a>
                        <button type="submit" class="btn btn-primary">{{ __("Submit") }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"
    integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw=="
    crossorigin="anonymous"></script>
<script>
    (function() {
        window.onload = function () {
            $('.select2').select2({ theme: 'bootstrap4' })
            $('.datetimepicker').datetimepicker({
                timepicker: false,
                format: 'Y-m-d'
            })
        }
    })()
</script>
@endpush
