<div id="logo-panel" class="panel {{ $company->hasLogo() ? 'panel-success' : 'panel-danger' }}">
    <div class="panel-heading">
        <h3 class="panel-title">Logga</h3>
    </div>

    <div class="panel-body">
        <p class="not-active">Företaget har ingen logga uppladdad.</p>
        <hr class="not-active">

        {{ Form::open(['data-remote', 'method' => 'POST', 'url' => $company->id . '/setLogo', 'files' => true, 'data-target' => 'logo']) }}
        <div class="is-active">
            <div class="form-group">
                <label for="logo">Nuvarande logga</label>
            </div>
            <div class="form-group row">
                <img id="logo-img" class="col-sm-6 col-xs-12" src="{{ !empty($company->logo_path) ? 'uploads/' . $company->logo_path : '' }}" alt="Logga">
            </div>
            <div class="form-group">
                <div class="alert alert-danger" id="og-image-check-denied" style="display: none;">
                    <p>
                        Loggan är inte godkänd för Facebook-delning. Loggan måste vara minst 200x200 pixlar stor.
                    </p>
                </div>
                <div class="alert alert-info" id="og-image-check-approved" style="display: none;">
                    <p>
                        Loggan är godkänd för Facebook-delning. Loggan kommer att användas när företagets annonser delas på Facebook.
                    </p>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label class="is-active" for="logo">Ladda upp en ny logga</label>
            <label class="not-active" for="logo">Ladda upp logga</label>
            {!! Form::file('logo') !!}
            <p class="help-block">Max storlek 300KB</p>
            <p class="help-block is-active">Den nuvarande loggan tas bort vid uppladdning av ny</p>
        </div>
        <div class="form-group">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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