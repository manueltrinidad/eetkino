@extends('layouts.app')
@section('title', 'All Names')
@section('content')
<br>
<h2>Temporary Section with all Names and IDS</h2>
<hr>
<ul>
    @foreach ($names as $name)
    <li>{{$name->id}}: <a href="{{route('names.show', $name->id)}}">{{$name->name}}</a></li>
    @endforeach
</ul>
@endsection