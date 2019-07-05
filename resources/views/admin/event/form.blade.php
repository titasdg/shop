<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Pavadinimas', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
    {!! Form::label('content', 'Aprašymas', ['class' => 'control-label']) !!}
    {!! Form::textarea('content', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('date') ? 'has-error' : ''}}">
    {!! Form::label('date', 'Data', ['class' => 'control-label']) !!}
    {!! Form::date('date', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('time') ? 'has-error' : ''}}">
    {!! Form::label('time', 'Laikas', ['class' => 'control-label']) !!}
    {!! Form::input('time', 'time', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('time', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('photo') ? 'has-error' : ''}}">
   <label for="photos[]" class="control-label">Photo</label>
    <input name="photos[]" type="file" multiple class="form-control" {{$required=($formMode==='edit'?'':'required')}}>
    {!! $errors->first('photo', '<p class="help-block">:message</p>') !!}
</div>
@if($formMode==='edit')
    @foreach($eventPhoto as $photo)
        <div class="edit-photo">
             <img src="{{asset('storage/'.$photo->image)}}">
            <a onclick="return confirm('Ar tikrai norite istrinti nuotrauka?')" href="{{ url('/admin/event/'.$event->id.'/photo/'.$photo->id) }}" title="Delete Photo"><i class="fas fa-times-circle"></i></a>
            
        </div>
    @endforeach
@endif
<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Redaguoti' : 'Kurti', ['class' => 'btn btn-primary']) !!}
</div>
