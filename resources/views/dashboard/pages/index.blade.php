@extends('index')

@section('dashboard')

    <h2 class="sub-header">Alla sidor</h2>

    <div class="bs-callout bs-callout-info">
        <p>
            Här listas alla sidor som har skapats. Du kan ändra innehållet på sidan genom att klicka på sidans namn.
        </p>
    </div>

    @if(count($pages) > 0)
        @foreach($pages as $page)
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <a href="{{ route('editPage', $page->id) }}">{{ $page->title }}</a>
                            <a data-confirm="delete" class="pull-right" href="{{ action('PagesController@delete', ['pageId' => $page->id]) }}">
                                <i class="fa fa-times btn-delete"></i>
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="bs-callout bs-callout-warning">
            <p>Det finns inga sidor.</p>
        </div>
    @endif

    <div class="col-xs-12">
        <button class="btn btn-primary" data-toggle="new-page-form" data-target="new-page-form">
            <i class="fa fa-plus"></i>
        </button>
    </div>

    {{ Form::model('Page', ['action' => 'PagesController@create']) }}
    <div class="row m-t-2">
        <div class="col-lg-4">
            <div class="form-group toggle-hide" id="new-page-form">
                {{ Form::label('title', 'Sidnamn') }}
                {{ Form::input('text', 'title', null, ['class' => 'form-control col-lg-4', 'autofocus']) }}
            </div>
        </div>
    </div>

    {{ Form::close() }}



@endsection