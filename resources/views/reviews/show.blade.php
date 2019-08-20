@extends('layouts.app')
@section('title')
<?php
$year = date('Y', strtotime($film->release_date));
$full_date = date('j F Y', strtotime($film->release_date));
echo "$film->title_english ($year)"
?>
@endsection
@section('content')
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
            <div class="col-sm-4">
                <h2>
                    {{ucfirst($film->film_type)}} Information
                    @auth
                    @include('films.editlink')
                    @endauth
                </h2>
                <hr>
                <h4><a href="{{route('films.show', $film->id)}}">{{$film->title_english}}</a></h4>
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
                @if ($film->poster_url)
                <img src="{{$film->poster_url}}" alt="{{$film->title_english}}" class="films-show-poster">
                @endif
            </div>
        </div>
    </div>
</div>
@auth
@include('films.editmodal')
@include('reviews.editmodal')
@endauth
@endsection