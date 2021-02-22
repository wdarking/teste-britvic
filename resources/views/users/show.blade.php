@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        {{ __("User: :name", ['name' => $user->name]) }}
                        <div class="float-right">
                            <div class="btn-group">
                                <a href="{{ route('users.edit', [$user]) }}"
                                    class="btn btn-sm btn-secondary">{{ __("Edit") }}</a>
                                <a href="{{ route('users.destroy', [$user]) }}" class="btn btn-sm btn-danger"
                                    data-toggle="modal" data-target="#deleteUserModal">
                                    {{ __("Delete") }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col">
                                <ul class="list-group">
                                    <li class="list-group-item">{{ __("Name") }}: {{ $user->name }}</li>
                                    <li class="list-group-item">{{ __("Document") }}: {{ $user->document }}</li>
                                    <li class="list-group-item">{{ __("Email") }}: {{ $user->email }}</li>
                                    <li class="list-group-item">{{ __("Created at") }}: {{ $user->created_at->format('d/m/Y') }}</li>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-3">
                                <img class="img-fluid"
                                    src="https://via.placeholder.com/200x200?text={{ $user->name }}" alt="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __("Reservations for :user", ['user' => $user->name]) }}</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __("Customer") }}</th>
                                        <th scope="col">{{ __("Reservation Date") }}</th>
                                        <th scope="col">{{ __("Vehicle") }}</th>
                                        <th scope="col">{{ __("Actions") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                    <tr>
                                        <th scope="row">{{ $reservation->id }}</th>
                                        <td>{{ $reservation->user->name }}</td>
                                        <td>{{ $reservation->formated_date }}</td>
                                        <td>
                                            {{ $reservation->vehicle->name }} | <a
                                                href="{{ route('reservations.show', [$reservation->vehicle]) }}"
                                                target="_blank">{{ $reservation->vehicle->license_plate }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('reservations.show', [$reservation]) }}"
                                                class="btn btn-sm btn-primary">{{ __('View') }}</a>
                                            <a href="{{ route('reservations.edit', [$reservation]) }}"
                                                class="btn btn-sm btn-secondary">{{ __('Edit') }}</a>
                                            <a href="{{ route('reservations.show', [$reservation, 'delete' => 1]) }}"
                                                class="btn btn-sm btn-danger">{{ __('Delete') }}</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="m-2">
                                {{ $reservations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">{{ __("Are you sure?") }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __("You are deleting user :name (:id). This action is not reversible.", ['name' => $user->name, 'id' => $user->id]) }}
                </p>
                <form id="deleteCarForm" action="{{ route('users.destroy', [$user]) }}" method="POST">
                    @csrf
                    @method('delete')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
                <button type="submit" class="btn btn-danger"
                    form="deleteCarForm">{{ __("Yes, delete user") }}</button>
            </div>
        </div>
    </div>
</div>

@if(request()->query('delete'))
<script>
    (function() {
        window.onload = function() {
            $('#deleteUserModal').modal('show')

            $('#deleteUserModal').on('hidden.bs.modal', function (event) {
                window.location.href = "{{ route('users.show', [$user]) }}"
            })
        }
    })()
</script>
@endif
@endsection
