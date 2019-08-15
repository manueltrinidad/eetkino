@extends('layouts.app')
@section('title', 'Watchlists')
@section('content')
<br>
<h2>Watchlists</h2>
<hr>
<ul>
    @foreach ($watchlists as $watchlist)
    <li><a href="{{route('watchlists.show', $watchlist->id)}}">{{$watchlist->title}}</a></li>
    @endforeach
</ul>
@endsection