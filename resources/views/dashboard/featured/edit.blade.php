@extends('index')

@section('dashboard')

    <h2 class="sub-header">Skapa/ändra företagspresentation</h2>

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
                    <label for="title">Rubrik</label>

                    {{ Form::text('title', $featured->title, ['required', 'class' => 'form-control', 'placeholder' => 'Företagets namn, eller det du vill ska vara presentationens rubrik']) }}
                </h3>
            </div>
            <div class="panel-body">

                <div class="row">

                    <div class="form-group col-lg-6">
                        <label for="subtitle">Underrubrik</label>

                        {{ Form::text('subtitle', $featured->subtitle, ['class' => 'form-control', 'placeholder' => 'Företagets slogan, eller något annat kul!']) }}

                    </div>

                </div>

                <div class="form-group">
                    <label for="description">Beskrivning</label>
                    {!! Form::textarea('description', $featured->description, ['required', 'class' => 'form-control summernote-extended']) !!}
                </div>
                <div class="row">
                    <div class="form-group col-xs-12">
                        <button data-submit type="submit" class="btn btn-primary btn-submit col-md-2">Spara</button>
                        <a href="{{ route('featured') }}" class="btn btn-warning col-md-2 pull-right">
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
