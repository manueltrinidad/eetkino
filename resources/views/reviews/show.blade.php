@extends('layouts.app')
@section('title')
<?php
$year = date('Y', strtotime($film->release_date));
$full_date = date('j F Y', strtotime($film->release_date));
echo "$film->title_english ($year)"
?>
@endsection
@section('content')
<meta name="film-id-meta" content="{{$film->id}}"/>
<meta name="review-id-meta" content="{{$review->id}}"/>
<br>
<div class="row justify-content-center">
    <div class="col-sm-10">
        <div class="row">
            <div class="col-sm-8">
                <h2>
                    @if ($review->is_draft == 1)
                    DRAFT
                    @endif
                    Review: {{$film->title_english}} ({{$year}})
                    @auth
                    @include('reviews.editlink')
                    @endauth
                </h2>
                <h5><i>Score: {{$review->score}} / 100</i></h5>
                <hr>
                @markdown($review->content)
                By: KiNO {{$review->review_date}}
                <hr>
            </div>
            <div id="film-info" class="col-sm-4">
                <div id="poster">
                    @if ($film->poster_url)
                    <img src="{{$film->poster_url}}" alt="{{$film->title_english}}" class="films-show-poster">
                    <hr>
                    @endif
                </div>
                <div id="title-english">
                    <h4>
                        @if ($film->imdb_id)
                        <a href="https://www.imdb.com/title/{{$film->imdb_id}}">{{$film->title_english}}</a>
                        @else
                        {{$film->title_english}}
                        @endif
                        @auth
                        @include('films.editlink')
                        @endauth
                    </h4>
                </div>
                <div id="title-native">
                    @if ($film->title_native)
                    <h6>{{$film->title_native}} (native title)</h6>
                    @endif
                </div>
                <div id="release-date">
                    <h6>Release Date: {{$full_date}}</h6>
                </div>
                <hr>
                <div id="countries">
                    <h4>Production Countries</h4>
                    <p>
                        @foreach ($film->countries as $country)
                        <b>{{$country->name}}</b> |
                        @endforeach
                    </p>
                </div>
                <hr>
                <h4>Crew</h4>
                <div id="directors">
                    <h6><b>Directors</b></h6>
                    <p>
                        @foreach ($film->names as $name)
                        @if ($name->pivot->credit == 'director')
                        <a href="{{route('names.show', $name->id)}}">{{$name->name}}</a> |
                        @endif
                        @endforeach
                    </p>
                </div>
                <div id="writers">
                    <h6><b>Writers</b></h6>
                    <p>
                        @foreach ($film->names as $name)
                        @if ($name->pivot->credit == 'writer')
                        <a href="{{route('names.show', $name->id)}}">{{$name->name}}</a> |
                        @endif
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@auth
@include('films.editmodal')
@include('reviews.editmodal')
@endauth
@endsection