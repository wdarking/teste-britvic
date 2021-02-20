@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="card">
            <div class="card-header">
                {{ __('Vehicles') }}
                <div class="float-right">
                    <a href="{{ route('vehicles.create') }}" class="btn btn-sm btn-primary">{{ __("Add Vehicle") }}</a>
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
                            @foreach($vehicles as $vehicle)
                            <tr>
                                <th scope="row">{{ $vehicle->id }}</th>
                                <td>{{ $vehicle->name }}</td>
                                <td>{{ $vehicle->year }}</td>
                                <td>{{ $vehicle->brand }}</td>
                                <td>{{ $vehicle->model }}</td>
                                <td>{{ $vehicle->license_plate }}</td>
                                <td>
                                    <a href="{{ route('vehicles.show', [$vehicle]) }}" class="btn btn-sm btn-primary">{{ __('View') }}</a>
                                    <a href="{{ route('vehicles.edit', [$vehicle]) }}" class="btn btn-sm btn-secondary">{{ __('Edit') }}</a>
                                    <a href="{{ route('vehicles.show', [$vehicle, 'delete' => 1]) }}" class="btn btn-sm btn-danger">{{ __('Delete') }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="m-2">
                        {{ $vehicles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
