<div id="profiled-panel" class="panel {{ $job->isCurrentlyProfiled() ? 'panel-success' : 'panel-danger' }}">
    <div class="panel-heading">
        <h3 class="panel-title">Profilerat jobb</h3>
    </div>

    <div class="panel-body">
        @if($job->isCurrentlyProfiled())
            <p>Jobbet är just nu profilerat.</p>
        @else
            <p>Jobbet är inte profilerat.</p>
        @endif

        <hr/>

        @if(!$job->isCurrentlyProfiled())
            <p>Vill du registrera jobbet som profilerat kan du klicka i rutan nedan, välja ett slutdatum för annonsen och trycka på spara.</p>
        @else
            <p>Vill du inte längre att jobbet ska vara profilerat kan du klicka ur rutan nedan och trycka på spara.</p>
        @endif

        <div class="form-group">
            {!! Form::checkbox('profiled', null, $job->isCurrentlyProfiled() ? 1 : 0, ['data-date-toggle' => 'profiled']) !!}
            <label for="profiled">Profilerat jobb</label>
        </div>
        <div class="form-group" id="profiled-date-picker" {{ $job->isCurrentlyProfiled() ? "" : "style=display:none;" }}>
            <label for="profiled-end" aria-label="Slutdatum för profilerad jobbannons.">Profilerad arbetsgivare till och med</label>
            {!! Form::date('profiled-end', $job->isCurrentlyProfiled() ? \Carbon\Carbon::parse($job->profiledJob->end_date)->toDateString() : \Carbon\Carbon::now()->addWeek(1)) !!}
            <br><br>
            <label for="profiled_title">Alternativ titel</label>
            <p class="help-block">Denna titel syns endast på förstasidan. Lämnas fältet tomt så används jobbets vanliga titel.</p>
            {{ Form::text('profiled_title', ($job->profiledJob()->count() > 0) ? $job->profiledJob->title : '', ['class' => 'form-control']) }}
        </div>
    </div>
</div>