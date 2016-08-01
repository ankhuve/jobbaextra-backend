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

            @if(isset($jobs))
                @foreach($jobs as $job)

                    <tr>
                        <td>{{ $job->title }}</td>
                        <td>{{ $job->latest_application_date }}</td>
                        <td>{{ $job->contact_email }}</td>
                        <td>{{ $job->type }}</td>
                        <td>{{ $job->county }}</td>
                    </tr>

                @endforeach
            @endif



            </tbody>
        </table>
    </div>

@endsection