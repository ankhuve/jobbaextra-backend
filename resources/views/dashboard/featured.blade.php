@extends('index')

@section('dashboard')

    <h2 class="sub-header">Attraktiva arbetsgivare</h2>

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

            @if(isset($companies))
                @foreach($companies as $company)

                    <tr>
                        <td>{{ $company->company->name }}</td>
                        <td>{{ $company->company->email }}</td>
                        <td>{{ $company->company->created_at }}</td>
                    </tr>

                @endforeach
            @endif



            </tbody>
        </table>
    </div>

@endsection