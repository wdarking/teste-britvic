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
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="carName" name="name" value="{{ old('name') ?? $car->name }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="carYear">{{ __("Year") }}</label>
                        <input type="text" class="form-control @error('year') is-invalid @enderror" id="carYear" name="year" value="{{ old('year') ?? $car->year }}">
                        @error('year')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="carBrand">{{ __("Brand") }}</label>
                        <input type="text" class="form-control @error('brand') is-invalid @enderror" id="carBrand" name="brand" value="{{ old('brand') ?? $car->brand }}">
                        @error('brand')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="carModel">{{ __("Model") }}</label>
                        <input type="text" class="form-control @error('model') is-invalid @enderror" id="carModel" name="model" value="{{ old('model') ?? $car->model }}">
                        @error('model')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="licensePlate">{{ __("License Plate") }}</label>
                        <input type="text" class="form-control @error('license_plate') is-invalid @enderror" id="licensePlate" name="license_plate" value="{{ old('license_plate') ?? $car->license_plate }}">
                        @error('license_plate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary float-right">{{ __("Submit") }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
