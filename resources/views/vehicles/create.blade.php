@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="card">
            <div class="card-header">{{ __('Add Vehicle') }}</div>

            <div class="card-body">

                <form action="{{ route('vehicles.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="vehicleName">{{ __("Name") }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="vehicleName" name="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="vehicleYear">{{ __("Year") }}</label>
                        <input type="text" class="form-control @error('year') is-invalid @enderror" id="vehicleYear" name="year">
                        @error('year')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="vehicleBrand">{{ __("Brand") }}</label>
                        <input type="text" class="form-control @error('brand') is-invalid @enderror" id="vehicleBrand" name="brand">
                        @error('brand')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="vehicleModel">{{ __("Model") }}</label>
                        <input type="text" class="form-control @error('model') is-invalid @enderror" id="vehicleModel" name="model">
                        @error('model')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="licensePlate">{{ __("License Plate") }}</label>
                        <input type="text" class="form-control @error('license_plate') is-invalid @enderror" id="licensePlate" name="license_plate">
                        @error('license_plate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="float-right">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">{{ __("Back") }}</a>
                    <button type="submit" class="btn btn-primary">{{ __("Submit") }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
