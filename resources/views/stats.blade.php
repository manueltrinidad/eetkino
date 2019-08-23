@extends('layouts.app')
<?php

// Calculations
// Maybe I should make a daily cache file... Or one that gets updated everytime I post something a film... HMMM...
// Anyways I'll need the calculatons right now so yeah.

$total_reviews = count($reviews);
$avg_score = round((collect($reviews)->sum('score')/count($reviews)), 1);

$now = time();
$first_date = strtotime($reviews->min('review_date'));
$datediff = (int)(($now - $first_date) / (60 * 60 * 24));

?>
@section('title', 'Statistics')
@section('content')
<br>
<div class="jumbotron">
    <h1 class="display-4">Statistics</h1>
    <p class="lead">Numbers on the movies I've watched / reviewed</p>
</div>
<div class="row">
    <div class="col-sm-3">
        Movies Reviewed: {{$total_reviews}}
    </div>
    <div class="col-sm-3">
        Average Score: {{$avg_score}}
    </div>
    <div class="col-sm-3">
        Up For: {{$datediff}} days.
        <br>
        @if (($total_reviews / $datediff) > 1)
        {{$total_reviews / $datediff}} movies per day
        @else
        {{$total_reviews / $datediff}} movie per day.
        @endif
    </div>
</div>
<hr>
<h5>Soon, Movies by Country, Decade, etc.</h5>
@endsection