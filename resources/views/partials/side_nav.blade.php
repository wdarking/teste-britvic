<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="nav flex-column nav-pills" id="v-pills-tab">
                            <a class="nav-link @if(request()->is('home')) active @endif" href="/home" role="tab">{{ __("Home") }}</a>
                            <a class="nav-link @if(request()->is('users')) active @endif" href="/users" role="tab">{{ __("Users") }}</a>
                            <a class="nav-link @if(request()->is('cars')) active @endif" href="/cars" role="tab">{{ __("Cars") }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
