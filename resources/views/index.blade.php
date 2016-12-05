@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <a href="{{ env('URL_FRONT', 'www.jobbrek.se') }}" target="_blank">
                    <img class="img img-responsive img-rounded m-b-2" src="{{ asset('img/logo_small_bg.png') }}" alt="{{ config('app.name', 'Jobbrek') }}">
                </a>
                <ul class="nav nav-sidebar">
                    <li class="{{ Route::currentRouteName() === 'home' ? 'active' : '' }}">
                        <a href="{{ route('home') }}">
                            Alla företag
                            {!! Route::currentRouteName() === 'home' ? '<span class="sr-only">(current)</span>' : '' !!}
                        </a>
                    </li>
                    <li class="{{ Route::currentRouteName() === 'jobs' ? 'active' : '' }}">
                        <a href="{{ route('jobs') }}">
                            Alla jobb
                        </a>
                    </li>
                    <li class="{{ Route::currentRouteName() === 'featured' ? 'active' : '' }}">
                        <a href="{{ route('featured') }}">
                            Attraktiva arbetsgivare
                        </a>
                    </li>
                    <li class="{{ Route::currentRouteName() === 'pages' ? 'active' : '' }}">
                        <a href="{{ route('pages') }}">
                            Sidinnehåll
                        </a>
                    </li>
                    <li class="{{ Route::currentRouteName() === 'users' ? 'active' : '' }}">
                        <a href="{{ route('users') }}">
                            Användare
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">
                            Registrera nytt företag
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                @yield('dashboard')
            </div>

        </div>
    </div>

@endsection
