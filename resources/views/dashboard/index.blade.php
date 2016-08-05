@extends('index')

@section('dashboard')
    <h2 class="sub-header">Registrerade företag</h2>
    <div class="bs-callout bs-callout-info">
        <p>Här är en massa text som förklarar saker.</p>
        <p>Du kan även <a href="{{ url('register') }}">registrera ett nytt företag</a>.</p>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Namn</th>
                <th>Antal jobbannonser</th>
                <th>E-mail</th>
                <th>Konto skapat</th>
                <th>Betalande kund</th>
                <th>Attraktiv arbetsgivare</th>
            </tr>
            </thead>
            <tbody>

            @if(isset($users))
                @foreach($users as $company)

                    <tr>
                        <td><a href="{{ action('DashboardController@companyJobs', ['company' => $company]) }}">{{ $company->name }}</a></td>
                        <td>{{ $company->numJobs() }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ $company->created_at }}</td>
                        <td>{!! $company->isPaying() ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>' !!}</td>
                        <td>{!! $company->isFeatured() ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>' !!}</td>
                    </tr>

                @endforeach
            @endif



            </tbody>
        </table>
    </div>
@endsection