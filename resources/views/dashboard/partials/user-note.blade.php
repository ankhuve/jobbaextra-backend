{{ Form::open(['data-remote', 'id' => 'content-' . $user->id, 'method' => 'POST', 'url' => $user->id . '/setNote', 'data-target' => 'content', 'style' => 'display:none;']) }}
<br>
<div class="form-group">
    <label for="content">Anteckningar</label>
    {{ Form::textarea('content', $user->note ? $user->note->content : null, ['class' => 'form-control']) }}
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