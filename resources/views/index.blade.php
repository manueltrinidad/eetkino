@extends('layouts.app')

@section('title', 'Culture Kino')

@section('content')
@include('layouts.partials.create')
<br>
<h3>Latest Reviews</h3>
<hr>

@foreach ($reviews as $review)
@if ($loop->iteration == 1 or $loop->iteration%5 == 0)
<div class="row">
    @endif
    <div class="col-sm-3">
        <div class="card">
            @if ($review->film->poster_url)
            <a href="{{ route('reviews.show', $review->id) }}">
                <img src="{{$review->film->poster_url}}" alt="{{ $review->film->title_english }}" class="card-img-top">
            </a>
            @endif
            <div class="card-body">
                <h5 class="card-title"><a href="{{route('reviews.show', $review->id)}}">{{$review->film->title_english}}</a></h5>
                <p class="card-text">{{$review->score}} / 100</p>
            </div>
        </div>
    </div>
    @if ($loop->iteration%4 == 0 or $loop->last)
</div>
<br>
@endif
@endforeach

@if (count($drafts) != 0)

<hr>
@auth
<h3>Drafts</h3>
<hr>

@foreach ($drafts as $draft)
@if ($loop->iteration == 1 or $loop->iteration%5 == 0)
<div class="row">
    @endif
    <div class="col-sm-3">
        <div class="card">
            @if ($draft->film->poster_url)
            <a href="{{ route('reviews.show', $draft->id) }}">
                <img src="{{$draft->film->poster_url}}" alt="{{ $draft->film->title_english }}" class="card-img-top">
            </a>
            @endif
            <div class="card-body">
                <h5 class="card-title"><a href="{{route('reviews.show', $draft->id)}}">{{$draft->film->title_english}}</a></h5>
                <p class="card-text">{{$draft->score}} / 100</p>
            </div>
        </div>
    </div>
    @if ($loop->iteration%4 == 0 or $loop->last)
</div>
<br>
@endif
@endforeach
@endauth

@endif

@endsection

@section('optional-scripts')
@auth
@include('scripts.create')
@endauth
@endsection