<div id="paying-panel" class="panel {{ $company->isPaying() ? 'panel-success' : 'panel-danger' }}">
    <div class="panel-heading">
        <h3 class="panel-title">Betalande användare</h3>
    </div>

    <div class="panel-body">
        <p class="is-active">Företaget är en betalande användare.</p>
        <p class="not-active">Företaget är inte en betalande användare.</p>
        <hr>
        <p class="not-active">Vill du registrera företaget som betalande kan du klicka i rutan nedan, välja ett datum och trycka på spara.</p>
        <p class="is-active">Vill du inte längre att företaget ska vara en betalande användare kan du klicka ur rutan nedan och trycka på spara.</p>

        {{ Form::open(['data-remote', 'method' => 'POST', 'url' => $company->id . '/setPaying', 'data-target' => 'paying']) }}
        <div class="form-group">
            {!! Form::checkbox('paying', null, $company->isPaying(), ['data-date-toggle' => 'paying']) !!}
            <label for="paying">Betalande kund</label>
        </div>
        <div class="form-group" id="paying-date-picker" {{ $company->isPaying() ? "" : "style=display:none;" }}>
            <label for="paying-end">Betalande kund till och med</label>
            {!! Form::date('paying-end', $company->paying ? \Carbon\Carbon::parse($company->paid_until)->toDateString() : \Carbon\Carbon::now()) !!}

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