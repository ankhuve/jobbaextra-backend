@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li class="{{ Route::currentRouteName() === 'home' ? 'active' : '' }}">
                        <a href="{{ route('home') }}">
                            Översikt
                            {!! Route::currentRouteName() === 'home' ? '<span class="sr-only">(current)</span>' : '' !!}
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
