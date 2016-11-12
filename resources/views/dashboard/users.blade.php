@extends('index')

@section('dashboard')
    <h2 class="sub-header">Registrerade användare</h2>
    <div class="bs-callout bs-callout-info">
        <p>Här ser du alla registrerade användare.
            <br>
            För att se mer information om en användare kan du klicka på raden i tabellen.
        </p>
    </div>

    @if(isset($users))
        @foreach($users as $user)
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-primary user-info" id="{{ $user->id }}" style="display: none;">
                        <div class="panel-heading">
                            <h4>{{ $user->name }}</h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <h5 class="text-strong">Email</h5>
                                </div>
                                <div class="col-lg-8">
                                    <h5><a target="_blank" href="mailto:{{ $user->email }}">{{ $user->email }}</a></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <h5 class="text-strong">Registrerad</h5>
                                </div>
                                <div class="col-lg-8">
                                    <h5>{{ $user->created_at }}</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <h5 class="text-strong">Län</h5>
                                </div>
                                <div class="col-lg-8">
                                    @if(!empty($allFilters) && array_key_exists('lan', $allFilters))
                                        <h5>{{ $user->county ? $allFilters['lan'][$user->county] : "Inte angivet" }}</h5>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <h5 class="text-strong">Kategorier <span class="badge">{{ $user->categories ? count($user->categories) : "0" }}</span></h5>
                                </div>
                                <div class="col-lg-8">
                                    @if( $user->categories && !empty($allFilters) && array_key_exists('yrkesgrupper', $allFilters))
                                        <ul>
                                            @foreach($user->categories as $category)
                                                <li><h5>{{ $allFilters['yrkesgrupper'][$category] }}</h5></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            @if($user->hasCV())
                                <a class="center-block" href="{{ $user->getCVLink() }}" download>
                                    <button class="btn btn-primary m-t-1">
                                        <i class="fa fa-file" aria-hidden="true"></i> Hämta CV
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Namn</th>
                <th>E-mail</th>
                <th>Konto skapat</th>
                <th>Har CV</th>
            </tr>
            </thead>
            <tbody>

            @if(isset($users))
                @foreach($users as $user)

                    <tr class="interactive" data-toggle="user-info" data-toggle-hide=".user-info" data-target="{{ $user->id }}">
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{!! $user->hasCV() ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>' !!}</td>
                    </tr>

                @endforeach
            @endif



            </tbody>
        </table>
        {{--If we want to paginate--}}
        {{ $users->render() }}
    </div>
@endsection