@extends('index')

@section('dashboard')

    <h2 class="sub-header">Skapa jobb</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="col-lg-10 col-lg-offset-1">

        {{ Form::open(['route' => ['saveNewJob', $company->id] ]) }}
        <div class="panel panel-default">
            <div class="panel-heading">

                <h3 class="panel-title form-group-lg">
                    <label for="title">Jobbtitel</label>

                    {{ Form::text('title', null, ['class' => 'form-control', 'required']) }}
                </h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="type">Yrkesområde</label>
                        {{ Form::select('type[]', $jobTypes, null, ['class' => 'form-control', 'multiple', 'required']) }}
                        <p class="help-block">Tips! Håll in Ctrl (Windows) eller Cmd (Mac) för att välja flera.</p>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="work_place">Arbetsplats</label>

                        {{ Form::text('work_place', null, ['class' => 'form-control', 'required']) }}
                    </div>

                </div>

                <div class="form-group">
                    <label for="description">Beskrivning</label>
                    {!! Form::textarea('description', null, ['class' => 'form-control summernote', 'required']) !!}
                </div>
                <div class="row">

                    <div class="form-group col-lg-4">
                        <label for="latest_application_date">Sista ansökan</label>
                        {!! Form::date('latest_application_date', Carbon\Carbon::today()->addMonth(1), ['class' => 'form-control', 'required']) !!}
                    </div>
                    {{--<div class="form-group col-lg-3">--}}
                        {{--<label for="published_at">Publicerad</label>--}}
                        {{--{!! Form::date('published_at', null, ['class' => 'form-control', 'required']) !!}--}}
                    {{--</div>--}}

                    {{--{{ dd($allFilters['lan']) }}--}}

                    <div class="form-group col-lg-4">
                        <label for="county">Län</label>
                        {{ Form::select('county', $counties, null, ['class' => 'form-control', 'required']) }}
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="municipality">Kommun</label>
                        {{ Form::text('municipality', null, ['class' => 'form-control', 'required']) }}
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="contact_email">Kontaktemail</label>
                        {{ Form::text('contact_email', null, ['class' => 'form-control', 'required']) }}
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="external_link">Extern ansökningslänk</label>
                        {{ Form::text('external_link', null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group col-lg-6">
                        @include('dashboard.partials.profiled-panel')
                    </div>

                    <div class="form-group col-xs-12">
                        <button data-submit type="submit" class="btn btn-primary btn-submit col-md-2">Spara</button>
                        <a href="/{{ $company->id }}" class="btn btn-warning col-md-2 pull-right">
                            Tillbaka
                        </a>

                    </div>
                </div>

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


            </div>
        </div>
        {{ Form::close() }}

    </div>
@endsection
