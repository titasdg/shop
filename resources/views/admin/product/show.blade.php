@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Produktas: {{ $product->title }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/product') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atgal</button></a>
                        <a href="{{ url('/admin/product/' . $product->id . '/edit') }}" title="Edit Product"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Redaguoti</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['admin/product', $product->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Trinti', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete Product',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr><th> Pavadinimas </th><td> {{ $product->title }} </td></tr><tr><th> Aprašymas </th><td> {{ $product->content }} </td></tr>
                                    <tr><th> Kiekis </th><td> {{ $product->quantity }} </td></tr><tr><th> Svoris </th><td> {{ $product->capacity }} </td> </tr>
                                    <tr><th> Kaina </th><td> {{ $product->price }} </td></tr><tr><th> Nuolaida </th><td> {{ $product->discount }} </td></tr>
                                    <tr><th> Aktyvus </th><td> {{ $product->is_active }} </td></tr></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
