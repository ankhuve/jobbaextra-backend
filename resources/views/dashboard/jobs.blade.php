@extends('index')

@section('dashboard')

    <div class="modal fade" id="jobOwnerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {{ Form::open(['url' => 'changeJobOwner', 'data-remote', 'data-target' => 'changeOwner']) }}
                {{ Form::hidden('jobId', null, ['id' => 'jobId']) }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ändra ägare av jobbannons</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="changeJobOwner">Företag</label>
                        <select name="company" id="changeJobOwner" class="form-control">
                            @foreach($companies as $company)
                                <option class="companyOption" value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-submit>Save changes</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <h2 class="sub-header">Alla jobb</h2>

    <div class="bs-callout bs-callout-info">
        <p>
            Här listas alla jobbannonser som har skapats. Du kan ändra ägaren av en jobbannons genom att klicka på företagets namn.
            <br>För att se en annons på <a href="{{ config('app.url-front') }}">{{ config('app.name', 'Vardvakanser.se') }}</a> kan du klicka på annonsens titel.
        </p>
    </div>

    @if(count($jobs) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Jobbannonser</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Företag</th>
                        <th>Kontakt</th>
                        <th>Publiceringsdatum</th>
                        <th>Sista ansökan</th>
                        <th>Antal visningar</th>
                        <th>Ansökningar</th>
                        <th>Delat</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($jobs as $job)
                        <tr>
                            <td>
                                <a target="_blank" href="{{ env('URL_FRONT', 'http://localhost:3000') }}/jobb/{{ $job->id }}/{{ str_slug($job->title) }}">
                                    <i class="fa fa-external-link"></i>
                                </a>
                                <a href="/{{ $job->user->id . '/' . 'edit/' . $job->id }}">
                                    {{ $job->title }}
                                </a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#jobOwnerModal" data-current-owner="{{ $job->user->id }}" data-job-id="{{ $job->id }}">
                                    {{ $job->user->name }}
                                </button>
                            </td>
                            <td>{{ $job->contact_email }}</td>
                            <td>{{ $job->published_at }}</td>
                            <td>{{ $job->latest_application_date }}</td>
                            <td>{{ $job->page_views }}</td>
                            <td>{{ $job->application_clicks }}</td>
                            <td>
                                @if($job->isShared())
                                    <i class="fa fa-check"></i>
                                @else
                                    <i class="fa fa-times"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bs-callout bs-callout-warning">
            <p>Det finns inga jobbannonser.</p>
        </div>
    @endif

@endsection