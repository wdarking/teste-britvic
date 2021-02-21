<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="nav flex-column nav-pills" id="v-pills-tab">
                            <a class="nav-link @if(request()->is('home')) active @endif" href="{{ route('home') }}" role="tab">{{ __("Home") }}</a>
                            {{-- <a class="nav-link @if(request()->is('users')) active @endif" href="{{ route('users.index') }}" role="tab">{{ __("Users") }}</a> --}}
                            <a class="nav-link @if(request()->is('query')) active @endif" href="{{ route('query') }}" role="tab">{{ __("Query") }}</a>
                            <a class="nav-link @if(request()->is('vehicles')) active @endif" href="{{ route('vehicles.index') }}" role="tab">{{ __("Vehicles") }}</a>
                            <a class="nav-link @if(request()->is('reservations')) active @endif" href="{{ route('reservations.index') }}" role="tab">{{ __("Reservations") }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
