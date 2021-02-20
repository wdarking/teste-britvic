@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="card">
            <div class="card-header">
                {{ __('Cars') }}
                <div class="float-right">
                    <a href="{{ route('cars.create') }}" class="btn btn-sm btn-primary">{{ __("Add Car") }}</a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __("Name") }}</th>
                                <th scope="col">{{ __("Year") }}</th>
                                <th scope="col">{{ __("Brand") }}</th>
                                <th scope="col">{{ __("Model") }}</th>
                                <th scope="col">{{ __("License Plate") }}</th>
                                <th scope="col">{{ __("Actions") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cars as $car)
                            <tr>
                                <th scope="row">{{ $car->id }}</th>
                                <td>{{ $car->name }}</td>
                                <td>{{ $car->year }}</td>
                                <td>{{ $car->brand }}</td>
                                <td>{{ $car->model }}</td>
                                <td>{{ $car->license_plate }}</td>
                                <td>
                                    <a href="{{ route('cars.show', [$car]) }}" class="btn btn-sm btn-primary">{{ __('View') }}</a>
                                    <a href="{{ route('cars.edit', [$car]) }}" class="btn btn-sm btn-secondary">{{ __('Edit') }}</a>
                                    <a href="{{ route('cars.show', [$car, 'delete' => 1]) }}" class="btn btn-sm btn-danger">{{ __('Delete') }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="m-2">
                        {{ $cars->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
