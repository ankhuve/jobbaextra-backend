@extends('index')

@section('dashboard')

    <h2 class="sub-header">{{ $company->name }}</h2>

    @if (session('updated'))
        <div class="alert alert-success">
            {{ session('updated') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            @if($company->paying)

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Betalande användare</h3>
                    </div>
                    <div class="panel-body">
                        <p>Företaget är en betalande användare.</p>
                        <hr>
                        <p>Vill du inte längre att företaget ska vara en betalande användare kan du klicka ur rutan nedan och trycka på spara.</p>
                        <form action="{{ action('CompanyController@setPaying', $company) }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="paying" aria-label="...">Betalande kund</label>
                                <input type="checkbox" name="paying" id="paying" aria-label="Checkbox paying user" checked onchange="$('#paying-date-picker').toggle(200)">
                            </div>
                            <div class="form-group" id="paying-date-picker">
                                <label for="payingEnd" aria-label="...">Betalande kund till och med</label>
                                <input type="date" name="payingEnd" id="payingEnd" placeholder="{{ Carbon\Carbon::now()->addMonth(1) }}">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Spara</button>
                            </div>
                        </form>
                    </div>
                </div>

            @else

                <div class="panel {{ $company->paying ? 'panel-success' : 'panel-danger' }}">
                    <div class="panel-heading">
                        <h3 class="panel-title">Betalande användare</h3>
                    </div>
                    <div class="panel-body">
                        <p>{{ $company->paying ? 'Företaget är en betalande användare.' : 'Företaget är inte en betalande användare.' }}</p>
                        <form action="{{ action('CompanyController@setPaying', $company) }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="paying" aria-label="...">Betalande kund</label>
                                <input type="checkbox" name="paying" id="paying" aria-label="Checkbox for paying user">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Spara</button>
                            </div>
                        </form>
                    </div>
                </div>

            @endif


        </div>


        <div class="col-lg-6">
            <div class="panel {{ $company->paying ? 'panel-success' : 'panel-default' }}">
                <div class="panel-heading">
                    <h3 class="panel-title">Attraktiv arbetsgivare</h3>
                </div>
                <div class="panel-body">
                    <p>{{ $company->paying ? 'Företaget är en attraktiv arbetsgivare fram till ...' : 'Företaget är inte en attraktiv arbetsgivare.' }}</p>
                </div>
            </div>
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