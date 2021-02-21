@extends('layouts.app')

@push('head')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"
    integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g=="
    crossorigin="anonymous" />
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('partials.status')
        <div class="card mb-3 d-print-none">
            <div class="card-body">
                <form action="{{ route('query') }}" method="GET">
                    <div class="row">

                        <div class="col-2">
                            <select class="form-control select2" name="year">
                                <option value="{{ now()->format('Y') }}">{{ now()->format('Y') }}</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select class="form-control select2" name="month">
                                <option value="">{{ __("Choose...") }}</option>
                                @foreach ($months as $key => $month)
                                <option @if(request()->query('month') === (string)$key) selected="selected" @endif
                                    value="{{ $key }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control select2" name="vehicle_id">
                                <option value="">{{ __("Choose...") }}</option>
                                @foreach ($vehicles as $vehicle)
                                <option @if(request()->query('vehicle_id') == $vehicle->id) selected="selected" @endif
                                    value="{{ $vehicle->id }}">{{ $vehicle->name }} - {{ $vehicle->description }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <div class="float-right">
                                <a href="{{ route('query') }}" class="btn btn-secondary">{{ __("Clear") }}</a>
                                <button type="submit" class="btn btn-primary">{{ __("Search") }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if(count($dates))
        <div class="card">
            <div class="card-header">
                {{ $description }}
                <div class="float-right">
                    <a href="#" class="btn btn-sm btn-primary d-print-none" onclick="event.preventDefault();window.print();">{{ __("Print") }}</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">{{ __("Date") }}</th>
                                <th scope="col">{{ __("Reserved") }}</th>
                                <th scope="col">{{ __("Customer") }}</th>
                                <th scope="col">{{ __("Actions") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dates as $date)
                            <tr class="@if(data_get($date, 'reservation')) table-warning @endif">
                                <td>{{ data_get($date, 'date_formated') }}</td>
                                <td>
                                    @if(data_get($date, 'reservation'))
                                    <span class="badge badge-warning">{{ __("Yes") }}</span>
                                    @else
                                    <span class="badge badge-info">{{ __("No") }}</span>
                                    @endif
                                </td>
                                <td>{{ data_get($date, 'reservation.user.name') }}</td>
                                <td>
                                    @if(data_get($date, 'reservation'))
                                    <a href="{{ route('reservations.show', [$date['reservation']]) }}"
                                        class="btn btn-sm btn-secondary d-print-none"
                                        target="_blank">{{ __('View Reservation') }}</a>
                                    @else
                                    <a href="{{ route('reservations.create', [$date['reservation'], 'vehicle_id' => request()->query('vehicle_id'), 'date' => $date['date']]) }}"
                                        class="btn btn-sm btn-primary d-print-none">{{ __('Add Reservation') }}</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-info" role="alert">
            {{ __("No results found. Select year, month and vehicle above.") }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"
    integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw=="
    crossorigin="anonymous"></script>
<script>
    (function() {
        window.onload = function () {
            $('.select2').select2({ theme: 'bootstrap4' })
            $('.datetimepicker').datetimepicker({
                timepicker: false,
                format: 'Y-m-d'
            })
        }
    })()
</script>
@endpush
