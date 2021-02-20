@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="card">
            <div class="card-header">{{ __('Edit Car: :name', ['name' => $car->name]) }}</div>

            <div class="card-body">

                <form action="{{ route('cars.update', [$car]) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="carName">{{ __("Name") }}</label>
                        <input type="text" class="form-control" id="carName" name="name" value="{{ $car->name }}">
                    </div>
                    <div class="form-group">
                        <label for="carYear">{{ __("Year") }}</label>
                        <input type="text" class="form-control" id="carYear" name="year" value="{{ $car->year }}">
                    </div>
                    <div class="form-group">
                        <label for="carBrand">{{ __("Brand") }}</label>
                        <input type="text" class="form-control" id="carBrand" name="brand" value="{{ $car->brand }}">
                    </div>
                    <div class="form-group">
                        <label for="carModel">{{ __("Model") }}</label>
                        <input type="text" class="form-control" id="carModel" name="model" value="{{ $car->model }}">
                    </div>
                    <div class="form-group">
                        <label for="licensePlate">{{ __("License Plate") }}</label>
                        <input type="text" class="form-control" id="licensePlate" name="license_plate" value="{{ $car->license_plate }}">
                    </div>
                    <button type="submit" class="btn btn-primary float-right">{{ __("Submit") }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
