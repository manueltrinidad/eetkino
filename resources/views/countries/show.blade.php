@extends('layouts.app')
@section('title', $country->name)
@section('content')
<br>
<h2>
    {{$country->name}}
    @auth
    <a href="#" class="text-dark" data-toggle="modal" data-target="#editCountryModal">
        <i class="material-icons">edit</i>
    </a>
    @endauth
</h2>
<hr>

@auth

<!-- Edit Country Modal -->

<div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editCountryModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCountryModal">Edit Country</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{route('countries.update', $country->id)}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" class="form-control" type="text" name="name" value="{{$country->name}}" required>
                    </div>
                </div>
                @csrf
                @method('PUT')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Edit Country</button>
                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteCountryModal">Delete</a>
                </div>
            </form>
            @include('layouts.partials.errors')
        </div>
    </div>
</div>

<!-- Delete Country Modal -->

<div id="deleteCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteCountryModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCountryModal">Delete Country</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the name?</p>
            </div>
            <form method="post" action="{{route('countries.destroy', $country->id)}}">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete Country</button>
                </div>
            </form>
            @include('layouts.partials.errors')
        </div>
    </div>
</div>

@endauth
@endsection