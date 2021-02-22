@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="card">
            <div class="card-header">
                {{ __('Users') }}
                <div class="float-right">
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">{{ __("Add User") }}</a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __("Name") }}</th>
                                <th scope="col">{{ __("Document") }}</th>
                                {{-- <th scope="col">{{ __("Email") }}</th> --}}
                                <th scope="col">{{ __("Created at") }}</th>
                                <th scope="col">{{ __("Actions") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->document }}</td>
                                {{-- <td>{{ $user->email }}</td> --}}
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('users.show', [$user]) }}" class="btn btn-sm btn-primary">{{ __('View') }}</a>
                                    <a href="{{ route('users.edit', [$user]) }}" class="btn btn-sm btn-secondary">{{ __('Edit') }}</a>
                                    <a href="{{ route('users.show', [$user, 'delete' => 1]) }}" class="btn btn-sm btn-danger">{{ __('Delete') }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="m-2">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
