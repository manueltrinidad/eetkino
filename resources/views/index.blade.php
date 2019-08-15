@extends('layouts.app')

@section('title', 'KiNO')

@section('content')
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
                {{$loop->iteration%5}}
            </div>
        </div>
    </div>
    @if ($loop->iteration%4 == 0 or $loop->last)
</div>
<br>
@endif
@endforeach


@endsection