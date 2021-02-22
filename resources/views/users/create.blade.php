@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="card">
            <div class="card-header">{{ __('Add User') }}</div>

            <div class="card-body">

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="userName">{{ __("Name") }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="userName" name="name" value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="userDocument">{{ __("Document") }}</label>
                        <input type="text" class="form-control @error('document') is-invalid @enderror" id="userDocument" name="document" value="{{ old('document') }}">
                        @error('document')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="userEmail">{{ __("Email") }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="userEmail" name="email" value="{{ old('email') }}">
                        @error('email')
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
