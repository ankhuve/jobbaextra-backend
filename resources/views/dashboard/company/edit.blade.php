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
                    @if (!empty($allFilters))
                        @if(array_key_exists('yrkesgrupper', $allFilters))
                            <div class="form-group col-lg-6">
                                <label for="type">Yrkesområde</label>
                                {{ Form::select('type', $allFilters['yrkesgrupper'], $job->type, ['class' => 'form-control', 'placeholder' => 'Välj ett yrkesområde..']) }}
                            </div>
                        @endif
                    @endif

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
                    {{--<div class="form-group col-lg-3">--}}
                    {{--<label for="published_at">Publicerad</label>--}}
                    {{--{!! Form::date('published_at', Carbon\Carbon::parse($job->published_at), ['class' => 'form-control']) !!}--}}
                    {{--</div>--}}

                    @if (!empty($allFilters))
                        @if(array_key_exists('lan', $allFilters))
                            <div class="form-group col-lg-4">
                                <label for="county">Län</label>
                                <select name="county" class="form-control">
                                    <option value=''>Välj ett län..</option>
                                    <option value='155' {{ $job->county === 'Norge' || $job->county === '155' ? 'selected' : '' }}>Norge</option>
                                    <option value='' disabled>--------</option>

                                    @foreach($allFilters['lan'] as $key => $option)
                                        <option value={{ $key }} label='{{ $option }}' name='{{ $option }}' {{($job->county == $key) ? 'selected' : ''}} >{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    @endif

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
