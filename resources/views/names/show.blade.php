@extends('layouts.app')
@section('title', $name->name)

@section('content')
<br>
<h2>
    {{$name->name}}
    @auth
    @include('names.editlink')
    @endauth
</h2>
<hr>
<h4>Related Films</h4>
<hr>

{{-- This foreach mess is to see each credit in a single card --}}
<?php $n = -1?>
@foreach ($name->films as $film)
    @if ($n != $film->id)
        <?php $n = $film->id; $year = date('Y', strtotime($film->release_date)); ?>
        <h5>
            <a href="{{ route('films.show', $film->id) }}" class="text-dark">{{ $film->title_english }} ({{$year}})</a>
        </h5>
        @foreach ($name->films as $film_credit)
            @if ($film->id == $film_credit->id)
            {{ucfirst($film_credit->pivot->credit)}}
            @endif
        @endforeach
        <hr>
    @endif
@endforeach

@auth
@include('names.editmodal')
@endauth
@endsection