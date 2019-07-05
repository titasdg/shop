<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Pavadinimas', ['class' => 'control-label']) !!}
    {!! Form::text('title', null,('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control','required' => 'required']) !!}
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
    {!! Form::label('content', 'Aprašymas', ['class' => 'control-label']) !!}
    {!! Form::textarea('content', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control','required' => 'required']) !!}
    {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('quantity') ? 'has-error' : ''}}">
    {!! Form::label('quantity', 'Kiekis vnt', ['class' => 'control-label']) !!}
    {!! Form::number('quantity', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control','required' => 'required','min'=>"0"]) !!}
    {!! $errors->first('quantity', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('capacity') ? 'has-error' : ''}}">
    {!! Form::label('capacity', 'Svoris kg', ['class' => 'control-label']) !!}
    @foreach($weights as $weight)
    <div class="checkbox">
        <label>{!! Form::radio('capacity', $weight['value'],true) !!} {{$weight['value']}}</label>
    </div>    {!! $errors->first('capacity', '<p class="help-block">:message</p>') !!}
    @endforeach
</div>
<div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
    {!! Form::label('price', 'Kaina eur', ['class' => 'control-label']) !!}
    {!! Form::number('price', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required','step'=>'0.01'] : ['class' => 'form-control','step'=>'0.01','required' => 'required','min'=>"0"]) !!}
    {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('discount') ? 'has-error' : ''}}">
    {!! Form::label('discount', 'Nuolaida %', ['class' => 'control-label']) !!}
    {!! Form::number('discount', null, ('' == 'required') ? ['class' => 'form-control','max'=>"100"] : ['class' => 'form-control','max'=>"100",'min'=>"0"]) !!}
    {!! $errors->first('discount', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('photo') ? 'has-error' : ''}}">
   <label for="photos[]" class="control-label">Photo</label>
    @if($formMode==='edit' &&count($productPhoto)==0)
        <input name="photos[]" type="file" multiple class="form-control" required="required">
        @else
        <input name="photos[]" type="file" multiple class="form-control" {{$required=($formMode==='edit'?'':'required')}}>
    @endif
    {!! $errors->first('photo', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : ''}}">
    {!! Form::label('is_active', 'Aktyvus', ['class' => 'control-label']) !!}
    <div class="checkbox">
        <label>{!! Form::radio('is_active', '1',true) !!} Taip</label>
    </div>
    <div class="checkbox">
        <label>{!! Form::radio('is_active', '0') !!} Ne</label>
    </div>
    {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
</div>
@if($formMode==='edit')
    @foreach($productPhoto as $photo)
        <div class="edit-photo">
             <img src="{{asset('storage/'.$photo->image)}}">
            <a onclick="return confirm('Ar tikrai norite istrinti nuotrauka?')" href="{{ url('/admin/product/'.$product->id.'/photo/'.$photo->id) }}" title="Delete Photo"><i class="fas fa-times-circle"></i></a>
            
        </div>
    @endforeach
@endif
<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Redaguoti' : 'Kurti', ['class' => 'btn btn-primary']) !!}
</div>
