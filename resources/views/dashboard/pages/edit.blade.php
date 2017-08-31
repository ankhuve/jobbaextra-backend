@extends('index')

@section('dashboard')

    <h2 class="sub-header">{{ $page->title }}</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="bs-callout bs-callout-info">
        <p>
            Här listas alla block på sidan som för tillfället är editerbara. Vill du ändra något är det bara att ändra texterna och trycka på spara.
            <br><br>
            Glöm inte att titta på <a href="{{ config('app.url-front') }}">{{ env('APP_NAME', 'Jobbrek.se') }}</a> så att allt ser bra ut efter att du har sparat!
        </p>
    </div>

    <div class="col-lg-10 col-lg-offset-1">
        <div class="row">
            @foreach($content as $block)
                {{ Form::open(['data-remote', 'action' => ['PagesController@saveBlock', $block->id], 'data-target' => 'block-' . $block->id]) }}
                @if($block->type === 'register_puff')
                    <div class="col-lg-6">
                @else
                    <div class="col-xs-12">
                @endif
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label for="title">Blocktitel</label>
                            {{ Form::text('title', $block->title ?: null, ['class' => 'form-control']) }}
                        </h3>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="content">Innehåll</label>
                            {{ Form::textarea('content', $block->content ?: null, ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group">
                            <button data-submit type="submit" class="btn btn-primary btn-submit">Spara</button>
                        </div>

                        <div class="form-group error bs-callout bs-callout-danger">
                            Det uppstod ett fel. <a href="{{ \Illuminate\Support\Facades\URL::current() }}">Uppdatera sidan</a> och försök igen.
                            <hr>
                            Felmeddelande: <span></span>
                        </div>
                    </div>

                </div>
            </div>
            {{ Form::close() }}
            @endforeach

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

    </div>


@endsection