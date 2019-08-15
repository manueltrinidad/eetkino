@extends('layouts.app')
@section('title', 'All Countries')
@section('content')
<br>
<h2>Temporary Section with all Countries and IDS</h2>
<hr>
<ul>
    @foreach ($countries as $country)
    <li>{{$country->id}}: <a href="{{route('countries.show', $country->id)}}">{{$country->name}}</a></li>
    @endforeach
</ul>
@endsection