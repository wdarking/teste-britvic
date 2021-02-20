@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="card">
            <div class="card-header">{{ __('Add Car') }}</div>

            <div class="card-body">

                <form action="{{ route('cars.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="carName">{{ __("Name") }}</label>
                        <input type="text" class="form-control" id="carName" name="name">
                    </div>
                    <div class="form-group">
                        <label for="carYear">{{ __("Year") }}</label>
                        <input type="text" class="form-control" id="carYear" name="year">
                    </div>
                    <div class="form-group">
                        <label for="carBrand">{{ __("Brand") }}</label>
                        <input type="text" class="form-control" id="carBrand" name="brand">
                    </div>
                    <div class="form-group">
                        <label for="carModel">{{ __("Model") }}</label>
                        <input type="text" class="form-control" id="carModel" name="model">
                    </div>
                    <div class="form-group">
                        <label for="licensePlate">{{ __("License Plate") }}</label>
                        <input type="text" class="form-control" id="licensePlate" name="license_plate">
                    </div>
                    <button type="submit" class="btn btn-primary float-right">{{ __("Submit") }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
