@extends('index')

@section('dashboard')

    <h2 class="sub-header">Attraktiva arbetsgivare</h2>
    <div class="bs-callout bs-callout-info">
        <p>Här ser du alla attraktiva arbetsgivare.
            <br>
            En attraktiv arbetsgivare syns endast på Jobbrek.se om det har skapats en presentation för företaget.
        </p>
        <p>För att skapa en presentation för ett företag klickar du på namnet.</p>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Företag</th>
                <th>Kontaktemail</th>
                <th>Attraktiv till</th>
                <th>Skapat presentation</th>
            </tr>
            </thead>
            <tbody>

            @if(isset($companies))
                @foreach($companies as $company)

                    <tr>
                        <td><a href="{{ route('editFeatured', $company->company->id) }}">{{ $company->company->name }}</a></td>
                        <td>{{ $company->company->email }}</td>
                        <td>{{ $company->end_date }}</td>
                        <td>{!! $company->hasPresentation() ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>' !!}</td>
                    </tr>

                @endforeach
            @endif



            </tbody>
        </table>
    </div>

@endsection