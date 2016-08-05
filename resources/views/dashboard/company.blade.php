@extends('index')

@section('dashboard')

    <h2 class="sub-header">{{ $company->name }}</h2>

    <span id="companyPage" class="hidden"></span>

    <div class="flash-message">
        Uppdaterat!
    </div>

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
                        <th>#</th>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Header</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($jobs as $job)
                        <tr>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->latest_application_date }}</td>
                            <td>{{ $job->contact_email }}</td>
                            <td>{{ $job->type }}</td>
                            <td>{{ $job->county }}</td>
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