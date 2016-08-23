@extends('index')

@section('dashboard')

    <h2 class="sub-header">{{ $company->name }} <h4 class="help-block">{{ $company->email }}</h4></h2>

    <span id="companyPage" class="hidden"></span>

    {{--<div class="flash-message">--}}
        {{--Uppdaterat!--}}
    {{--</div>--}}

    <div class="row">
        <div class="col-lg-4">
            @include('dashboard.partials.paying-panel')
        </div>
        <div class="col-lg-4">
            @include('dashboard.partials.featured-panel')
        </div>
        <div class="col-lg-4">
            @include('dashboard.partials.upload-logo-panel')
        </div>
    </div>

    @if($company->hasJobs() > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Jobbannonser</h3>
            </div>
            <div class="panel-body">
                <p>Här listas alla jobbannonser som företaget har lagt ut. För att redigera en annons kan du klicka på annonsens titel.</p>


            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Yrkesområde</th>
                        <th>Kontakt</th>
                        <th>Kommun</th>
                        <th>Publiceringsdatum</th>
                        <th>Sista ansökan</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($jobs as $job)
                        <tr>
                            <td><a href="{{ URL::current() }}/edit/{{ $job->id }}">{{ $job->title }}</a></td>
                            <td>{{ $job->type }}</td>
                            <td>{{ $job->contact_email }}</td>
                            <td>{{ $job->municipality }}</td>
                            <td>{{ $job->published_at }}</td>
                            <td>{{ $job->latest_application_date }}</td>
                            <td><a data-confirm="delete" href="{{ action('CompanyController@delete', ['jobId' => $job->id, 'company' => $company->id]) }}"><i class="fa fa-times"></i></a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bs-callout bs-callout-warning">
            <p>Företaget har inte skapat några jobbannonser.</p>
        </div>
    @endif

@endsection