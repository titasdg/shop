<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::text('title', null, ('' == 'required') ? ['class' => 'form-control','disabled' => 'disabled'] : ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('value') ? 'has-error' : ''}}">
    {!! Form::label('value', 'Reikšmė', ['class' => 'control-label']) !!}
    {!! Form::number('value', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('value', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Išsaugoti' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
