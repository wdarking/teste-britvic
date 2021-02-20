@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="card">
            <div class="card-header">
                {{ __('Vehicle: :name', ['name' => $vehicle->name]) }}
                <div class="btn-group float-right">
                    <a href="{{ route('vehicles.edit', [$vehicle]) }}" class="btn btn-sm btn-secondary">{{ __("Edit") }}</a>
                    <a href="{{ route('vehicles.destroy', [$vehicle]) }}" class="btn btn-sm btn-danger" data-toggle="modal"
                        data-target="#deleteCarModal">
                        {{ __("Delete") }}
                    </a>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <ul class="list-group">
                            <li class="list-group-item">{{ __("Name") }}: {{ $vehicle->name }}</li>
                            <li class="list-group-item">{{ __("Year") }}: {{ $vehicle->year }}</li>
                            <li class="list-group-item">{{ __("Brand") }}: {{ $vehicle->brand }}</li>
                            <li class="list-group-item">{{ __("Model") }}: {{ $vehicle->model }}</li>
                            <li class="list-group-item">{{ __("License Plate") }}: {{ $vehicle->license_plate }}</li>
                        </ul>
                    </div>
                    <div class="col-3">
                        <img class="img-fluid" src="https://via.placeholder.com/200x200?text={{ $vehicle->name }}" alt="">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Delete Car Modal -->
<div class="modal fade" id="deleteCarModal" tabindex="-1" aria-labelledby="deleteCarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCarModalLabel">{{ __("Are you sure?") }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __("You are deleting vehicle :name (:id). This action is not reversible.", ['name' => $vehicle->name, 'id' => $vehicle->id]) }}
                </p>
                <form id="deleteCarForm" action="{{ route('vehicles.destroy', [$vehicle]) }}" method="POST">
                    @csrf
                    @method('delete')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
                <button type="submit" class="btn btn-danger" form="deleteCarForm">{{ __("Yes, delete vehicle") }}</button>
            </div>
        </div>
    </div>
</div>

@if(request()->query('delete'))
<script>
    (function() {
        window.onload = function() {
            $('#deleteCarModal').modal('show')

            $('#deleteCarModal').on('hidden.bs.modal', function (event) {
                window.location.href = "{{ route('vehicles.show', [$vehicle]) }}"
            })
        }
    })()
</script>
@endif
@endsection
