@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Redaguoti įrašą: {{ $blog->title }}</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/blog') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atgal</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($blog, [
                            'method' => 'PATCH',
                            'url' => ['/admin/blog', $blog->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('admin.blog.form', ['formMode' => 'edit'])

                        {!! Form::close() !!}
                       
                     
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
