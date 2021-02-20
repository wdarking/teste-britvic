@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="card">
            <div class="card-header">
                {{ __('Car: :name', ['name' => $car->name]) }}
                <div class="btn-group float-right">
                    <a href="{{ route('cars.edit', [$car]) }}" class="btn btn-sm btn-secondary">{{ __("Edit") }}</a>
                    <a href="{{ route('cars.destroy', [$car]) }}" class="btn btn-sm btn-danger" data-toggle="modal"
                        data-target="#deleteCarModal">
                        {{ __("Delete") }}
                    </a>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <ul class="list-group">
                            <li class="list-group-item">{{ __("Name") }}: {{ $car->name }}</li>
                            <li class="list-group-item">{{ __("Year") }}: {{ $car->year }}</li>
                            <li class="list-group-item">{{ __("Brand") }}: {{ $car->brand }}</li>
                            <li class="list-group-item">{{ __("Model") }}: {{ $car->model }}</li>
                            <li class="list-group-item">{{ __("License Plate") }}: {{ $car->license_plate }}</li>
                        </ul>
                    </div>
                    <div class="col-3">
                        <img class="img-fluid" src="https://via.placeholder.com/200x200?text={{ $car->name }}" alt="">
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
                <p>{{ __("You are deleting car :name (:id). This action is not reversible.", ['name' => $car->name, 'id' => $car->id]) }}
                </p>
                <form id="deleteCarForm" action="{{ route('cars.destroy', [$car]) }}" method="POST">
                    @csrf
                    @method('delete')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
                <button type="submit" class="btn btn-danger" form="deleteCarForm">{{ __("Yes, delete car") }}</button>
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
                window.location.href = "{{ route('cars.show', [$car]) }}"
            })
        }
    })()
</script>
@endif
@endsection
