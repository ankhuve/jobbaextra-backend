@extends('index')

@section('dashboard')

    <h2 class="sub-header">Facebook</h2>

    <div class="bs-callout bs-callout-info">
        <p>
            Här ser du till att Facebook-kopplingen till {{ env('APP_NAME') }} fungerar som den ska. Logga in med knappen nedan och ge tillgång till applikationen så att vi automatiskt kan posta nya jobbannonser på Facebook-sidan.
            <br><br>
            Är du redan inloggad så ska allt vara grönt, då vet vi att allt fungerar som det ska. Är det någon punkt som har ett rött kryss, försök återansluta.
        </p>
    </div>

    @if(!empty($pages))
        <h4>Inloggad som: {{ session('fb_user_name') ?: '' }}</h4>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Applikationsåtkomster</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Namn</th>
                            <th>Åtkomst</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission['name'] }}</td>
                                <td>{!! $permission['access'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' !!}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @if(!empty($pages))
        <a href="{{ $login_url }}">
            <button class="btn btn-warning">
                <i class="fa fa-facebook-square"></i> &nbsp;&nbsp; Återanslut
            </button>
        </a>
    @else
        <a href="{{ $login_url }}">
        <button class="btn btn-primary">
            <i class="fa fa-facebook-square"></i> &nbsp;&nbsp; Logga in
        </button>
        </a>
    @endif

    {{--{{ Form::open(['action' => ['FacebookController@post']]) }}--}}
    {{--<div class="row">--}}
        {{--<div class="col-md-4">--}}
            {{--{{ Form::textarea('message', null, ['class' => 'form-control']) }}--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="row">--}}
        {{--<div class="col-md-4">--}}
            {{--{{ Form::submit('Posta på Facebook', ['class' => 'btn btn-primary m-t-1']) }}--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection