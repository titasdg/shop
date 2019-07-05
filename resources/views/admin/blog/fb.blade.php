@extends('layouts.app')

@section('content')
    <form method="POST" action="/page">
        @csrf
        <input type="text" name="message">
        <input type="submit">
    </form>


@endsection()