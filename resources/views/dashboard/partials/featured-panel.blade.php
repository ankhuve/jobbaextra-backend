<div id="featured-panel" class="panel {{ $company->isFeatured() ? 'panel-success' : 'panel-danger' }}">
    <div class="panel-heading">
        <h3 class="panel-title">Attraktiv arbetsgivare</h3>
    </div>

    <div class="panel-body">
        <p class="is-active">Företaget är en attraktiv arbetsgivare.</p>
        <p class="not-active">Företaget är inte en attraktiv arbetsgivare.</p>
        <hr>
        <p class="not-active">Vill du registrera företaget som attraktiv arbetsgivare kan du klicka i rutan nedan, välja ett datum och trycka på spara.</p>
        <p class="is-active">Vill du inte längre att företaget ska vara en attraktiv arbetsgivare kan du klicka ur rutan nedan och trycka på spara.</p>

        {{ Form::open(['data-remote', 'method' => 'POST', 'url' => $company->id . '/setFeatured', 'data-target' => 'featured']) }}
        <div class="form-group">
            {!! Form::checkbox('featured', null, $company->isFeatured() ? 1 : 0, ['data-date-toggle' => 'featured']) !!}
            <label for="featured">Attraktiv arbetsgivare</label>
        </div>
        <div class="form-group" id="featured-date-picker" {{ $company->isFeatured() ? "" : "style=display:none;" }}>
            <label for="featured-end" aria-label="...">Betalande kund till och med</label>
            {!! Form::date('featured-end', $company->isFeatured() ? \Carbon\Carbon::parse($company->featured()->end_date)->toDateString() : \Carbon\Carbon::now()) !!}
        </div>
        <div class="form-group">
            <button data-submit type="submit" class="btn btn-primary btn-submit">Spara</button>
        </div>
        <div class="form-group error bs-callout bs-callout-danger">
            Det uppstod ett fel. <a href="{{ \Illuminate\Support\Facades\URL::current() }}">Uppdatera sidan</a> och försök igen.
            <hr>
            Felmeddelande: <span></span>
        </div>
        {{ Form::close() }}
    </div>
</div>