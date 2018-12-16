@if(isset($job))
    {{--Om vi är på ändra jobb-sidan--}}

    <div id="sharing-panel" class="panel {{ $job->isShared() ? 'panel-success' : 'panel-danger' }}">
        <div class="panel-heading">
            <h3 class="panel-title">Dela på Facebook</h3>
        </div>

        <div class="panel-body">
            @if($job->isShared())
                <p>Jobbet delades senast {{ \Carbon\Carbon::instance($job->shared->updated_at)->format('Y-m-d, H:i') }}.</p>
            @else
                <p>Jobbet är inte delat.</p>
            @endif

            <hr/>

            @if(!$job->isShared())
                <p>Vill du dela jobbet på Facebook klickar du på knappen nedan.</p>
            @else
                <p>Jobbet har redan delats på Facebook, men vill du dela det igen klickar du på knappen nedan.</p>
            @endif

            <div class="form-group">
                <a class="btn btn-primary" id="shareBtn" href="http://www.facebook.com/sharer.php?u={{ $linkToJob  }}" target="_blank">
                    Dela på Facebook
                </a>
            </div>

            <div class="form-group error bs-callout bs-callout-danger">
                Det uppstod ett fel. <a href="{{ url()->current() }}">Uppdatera sidan</a> och försök igen.
                <hr>
                Felmeddelande: <span></span>
            </div>
        </div>
    </div>
@endif