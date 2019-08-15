@extends('layouts.app')
@section('title', $watchlist->title)
@section('content')
<div class="jumbotron">
    <h1 class="display-4">
        {{$watchlist->title}}
        @auth
        @include('watchlists.editlink')
        @include('watchlists.editfilmslink')
        @endauth
    </h1>
    @if ($watchlist->description)
    <p class="lead">{{$watchlist->description}}</p>
    @endif
</div>
@foreach ($watchlist->films as $film)
<a href="{{route('films.show', $film->id)}}"><h5>{{$film->title_english}}</h5></a>
<hr>
@endforeach
@auth
@include('watchlists.editfilmsmodal')
@include('watchlists.editmodal')
@endauth
@endsection