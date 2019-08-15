@extends('layouts.app')
@section('title')
<?php
$year = date('Y', strtotime($film->release_date));
$full_date = date('jS \of F Y', strtotime($film->release_date));
echo "$film->title_english ($year)"
?>
@endsection
@section('content')
<br>
<h2>
    {{$film->title_english}} ({{$year}})
    @auth
    @include('films.editlink')
    @include('films.editwlistslink')
    @endauth
</h2>
<hr>
<div class="row">
    <div class="col-sm-4">
        <h4>Related Reviews</h4>
        <ul>
            @foreach ($film->reviews as $review)
            <li><a href="{{route('reviews.show', $review->id)}}">Review: {{$review->score}} / 100</a></li>   
            @endforeach
        </ul>
    </div>
    <div class="col-sm-3">
        @if ($film->poster_url)
        <img src="{{$film->poster_url}}" alt="{{$film->title_english}}" class="films-show-poster">
        @endif
    </div>
    <div class="col-sm-5">
        <h4>{{$film->title_english}}</h4>
        @if ($film->title_native)
        <h6>{{$film->title_native}} (native title)</h6>
        @endif
        <h6>Release Date: {{$full_date}}</h6>
        <hr>
        <h4>Production Countries</h4>
        <p>
            @foreach ($film->countries as $country)
            <b>{{$country->name}}</b> |
            @endforeach
        </p>
        <hr>
        <h4>Crew</h4>
        <h6><b>Directors</b></h6>
        <p>
            @foreach ($film->names as $name)
            @if ($name->pivot->credit == 'director')
            <a href="{{route('names.show', $name->id)}}">{{$name->name}}</a> |
            @endif
            @endforeach
        </p>
        <h6><b>Writers</b></h6>
        <p>
            @foreach ($film->names as $name)
            @if ($name->pivot->credit == 'writer')
            <a href="{{route('names.show', $name->id)}}">{{$name->name}}</a> |
            @endif
            @endforeach
        </p>
        @if ($film->imdb_id)
        <h6><a href="https://www.imdb.com/title/{{$film->imdb_id}}">IMDB Profile</a></h6>
        @endif
    </div>
</div>

@auth
@include('films.editmodal')
@include('films.editwlistsmodal')
@endauth
@endsection