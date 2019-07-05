@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Įrašas: {{ $blog->title }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/blog') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atgal</button></a>
                        <a href="{{ url('/admin/blog/' . $blog->id . '/edit') }}" title="Edit Blog"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Redaguoti</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['admin/blog', $blog->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Trinti', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete Blog',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $blog->id }}</td>
                                    </tr>
                                    <tr><th> Pavadinimas </th><td> {{ $blog->title }} </td></tr><tr><th> Aprašymas </th><td> {{ $blog->content }} </td></tr><tr><th> Tagas </th><td> {{ $blog->tag }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
