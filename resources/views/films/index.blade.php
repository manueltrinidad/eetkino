@extends('layouts.app')
@section('title', 'All Films')
@section('content')
<br>
<h2>Temporary Section with all Films and IDS</h2>
<hr>
<ul>
    @foreach ($films as $film)
    <li>{{$film->id}}: <a href="{{route('films.show', $film->id)}}">{{$film->title_english}}</a></li>
    @endforeach
</ul>
@endsection