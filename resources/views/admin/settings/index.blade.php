@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Nustatymai</div>
                    <div class="card-body">
                        <div class="table-responsive">
                                            <div class="card" style="float:left;">
                                                        <div class="card-body">
                                                        @if ($errors->any())
                                                            <ul class="alert alert-danger">
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif

                                                        {!! Form::model($settings[0], [
                                                            'method' => 'PATCH',
                                                            'url' => ['/admin/settings', $settings[0]->id],
                                                            'class' => 'form-horizontal bigger',
                                                            'files' => true
                                                        ]) !!}

                                                        @include ('admin.settings.form', ['formMode' => 'edit'])

                                                        {!! Form::close() !!}
                                                    </div>
                                            </div>

                            <div class="card" style="float:left;">
                                <div class="card-header">Svoriai</div>
                                <div class="card-body bigger">

                                    @foreach($weights as $item)
                                        <div class="row"></div>
                                        <tr>

                                            <td>{{ number_format($item->value,2) }} kg</td>
                                            <td>
                                                <form method="POST" action="{{ url('/admin/weights' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                </form>
                                                {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/admin/weights', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Ištrinti', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Shipping',
                                                        'onclick'=>'return confirm("Ar tikrai norite ištrinti ?")'
                                                )) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                        <form method="POST" action="{{ url('/admin/weights') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="form-group {{ $errors->has('value') ? 'has-error' : ''}}">
                                                <div class="card-header">Prideti svori</div>
                                                {!! Form::number('value', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required','step'=>'0.1'] : ['class' => 'form-control','step'=>'0.1','required' => 'required','min'=>0.1]) !!}
                                                {!! $errors->first('value', '<p class="help-block">:message</p>') !!}
                                            </div>

                                        <div class="form-group">
                                            <input class="btn btn-primary"  type="submit" value=" {{  'Prideti' }}">
                                        </div>
                                        </form>
                                </div>
                            </div>
                            <div class="card" style="float:left;">
                                <div class="card-header">Pristatymo būdai</div>
                                <div class="card-body bigger">
                        <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Pavadinimas</th><th>Kaina</th><th>Veiksmai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($shipping as $item)
                                    <tr>
                                    
                                        <td>{{ $item->title }}</td><td>{{ $item->price }}</td>
                                        <td>
                                            <a href="{{ url('/admin/shipping/' . $item->id . '/edit') }}" title="Edit Shipping"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Redaguoti</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/admin/shipping', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Ištrinti', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Shipping',
                                                        'onclick'=>'return confirm("Ar tikrai norite ištrinti ?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <a href="{{ url('/admin/shipping/create') }}" class="btn btn-primary btn-sm" title="Add New Shipping">
                            <i class="fa fa-plus" aria-hidden="true"></i> Prideti</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
