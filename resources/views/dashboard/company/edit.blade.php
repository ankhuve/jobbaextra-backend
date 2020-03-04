@extends('index')

@section('dashboard')

    <h2 class="sub-header">Ändra jobb</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="col-lg-10 col-lg-offset-1">

        {{ Form::open() }}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title form-group-lg">
                    <label for="title">Jobbtitel</label>

                    {{ Form::text('title', $job->title, ['class' => 'form-control', 'required']) }}
                </h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    {{--                    @if (!empty($allFilters))--}}
                    {{--                        @if(array_key_exists('yrkesomraden', $allFilters))--}}
                    <div class="form-group col-lg-6">
                        <label for="type">Yrkesområde</label>
                        @if(is_array(json_decode($job->type)))
                            <select class="form-control" multiple required name="type[]" id="type">
                                @foreach($jobTypes as $key => $value)
                                    {{ $isSelected = false }}
                                    @foreach(json_decode($job->type) as $type)
                                        @if($type == $key)
                                            <option value="{{ $type }}" selected>{{ $value }}</option>
                                            {{ $isSelected = true }}
                                        @endif
                                    @endforeach
                                    @if(!$isSelected)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @else
                            {{ Form::select('type[]', $jobTypes, $job->type, ['class' => 'form-control', 'multiple', 'required']) }}
                        @endif

                        {{--                        {{ Form::select('type[]', $jobTypes, $job->type, ['class' => 'form-control', 'multiple', 'required']) }}--}}
                        <p class="help-block">Tips! Håll in Ctrl (Windows) eller Cmd (Mac) för att välja flera.</p>
                    </div>
                    {{--                        @endif--}}
                    {{--                    @endif--}}

                    <div class="form-group col-lg-6">
                        <label for="work_place">Arbetsplats</label>

                        {{ Form::text('work_place', $job->work_place, ['class' => 'form-control']) }}
                    </div>

                </div>

                <div class="form-group">
                    <label for="description">Beskrivning</label>
                    {!! Form::textarea('description', $job->description, ['class' => 'form-control summernote']) !!}
                </div>
                <div class="row">

                    <div class="form-group col-lg-4">
                        <label for="latest_application_date">Sista ansökan</label>
                        {!! Form::date('latest_application_date', $job->latest_application_date, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="county">Län</label>
                        {{ Form::select('county', $counties, $job->county, ['class' => 'form-control', 'required']) }}
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="municipality">Kommun</label>
                        {{ Form::text('municipality', $job->municipality, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="contact_email">Kontaktemail</label>
                        {{ Form::text('contact_email', $job->contact_email, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="external_link">Extern ansökningslänk</label>
                        {{ Form::text('external_link', $job->external_link, ['class' => 'form-control']) }}
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
