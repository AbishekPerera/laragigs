@extends('layout')
@section('content')
@include('partials._search')
<h1>{{$listing['title']}}</h1>
<p>
    {{$listing['description']}}
</p>

@endsection