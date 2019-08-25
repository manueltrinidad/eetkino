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
                    <a id="review-edit-icon" href="#" class="text-dark">
                        <i class="material-icons">edit</i>
                    </a>
                    @endauth
                </h2>
                @auth
                <div id="edit-review-info" style="display: none;">
                    @include('reviews.edit-review-info')
                </div>
                @endauth
                <div id="review-info">
                    <h5><i>Score: {{$review->score}} / 100</i></h5>
                    <hr>
                    @markdown($review->content)
                    By: KiNO {{$review->review_date}}
                    <hr>
                </div>
            </div>
            <div id="film" class="col-sm-4">
                @auth
                <div id="edit-film-info">
                    Edit Movie Details
                    <a href="#" id="film-edit-icon" class="text-dark">
                        <i class="material-icons" style="font-size: 1rem;">edit</i>
                    </a>
                    <a href="#" id="film-edit-icon" class="text-dark" data-toggle="modal" data-target="#deleteFilmModal">
                        <i class="material-icons" style="font-size: 1rem;">delete</i>
                    </a>
                    <div style="display: none;">
                        <form method="post" action="{{route('films.update', $film->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title_english">Title</label>
                                <input type="text" name="title_english" id="title_english" class="form-control" aria-describedby="helpEditTitleEnglish" value="{{$film->title_english}}">
                                <small id="helpEditTitle" class="text-muted">Title of the movie in english.</small>
                            </div>
                            <div class="form-group">
                                <label for="title_native">Native title</label>
                                <input id="title_native" class="form-control" type="text" name="title_native" value="{{$film->title_native}}">
                            </div>
                            <div id="add-director" class="form-group">
                                <h6>
                                    Director(s)
                                    <a href="#" class="text-dark" data-toggle="modal" data-target="#create-director-modal">
                                        <i class="material-icons">add</i>
                                    </a>
                                </h6>
                                <input id="search-bar-director" class="form-control" type="text" name="search-director" data-toggle="dropdown" autocomplete="off">
                                <div class="dropdown-menu" id="search-director-dropdown" role="menu">
                                </div>
                            </div>
                            <div id="add-writer" class="form-group">
                                <h6>
                                    Writer(s)
                                    <a href="#" class="text-dark" data-toggle="modal" data-target="#create-writer-modal">
                                        <i class="material-icons">add</i>
                                    </a>
                                </h6>
                                <input id="search-bar-writer" class="form-control" type="text" name="search-writer" data-toggle="dropdown" autocomplete="off">
                                <div class="dropdown-menu" id="search-writer-dropdown" role="menu">
                                </div>
                            </div>
                            <div id="add-country" class="form-group">
                                <h6>
                                    Countries of Production
                                    <a href="#" class="text-dark" data-toggle="modal" data-target="#create-country-modal">
                                        <i class="material-icons">add</i>
                                    </a>
                                </h6>
                                <input id="search-bar-country" class="form-control" type="text" name="search-country" data-toggle="dropdown" autocomplete="off">
                                <div class="dropdown-menu" id="search-country-dropdown" role="menu">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="release_date">Release Date</label>
                                <input type="date"
                                class="form-control" name="release_date" id="release_date" value="{{$film->release_date}}"required>
                            </div>
                            <div class="form-group">
                                <label for="film_type">Type of Media</label>
                                <select name="film_type" class="form-control" id="film_type" aria-describedby="helpEditFilmType" required>
                                    <option value="film" {{$film->film_type == 'film' ? 'selected' : ''}}>Film</option>
                                    <option value="shortfilm" {{$film->film_type == 'shortfilm' ? 'selected' : ''}}>Short Film</option>
                                    <option value="series" {{$film->film_type == 'series' ? 'selected' : ''}}>Series Episode</option>
                                </select>
                                <small id="helpEditFilmType" class="form-text text-muted">Is this a Film, Short or Series?</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="imdb_id">IMDB ID</label>
                                <input type="text" class="form-control" name="imdb_id" id="imdb_id" aria-describedby="helpEditImdb_id" value="{{$film->imdb_id}}">
                                <small id="helpEditImdb_id" class="form-text text-muted">Format is usually 'tt...'</small>
                            </div>
                            <div class="form-group">
                                <label for="poster_url">Poster URL (provitional)</label>
                                <input type="text" class="form-control" name="poster_url" id="poster_url" aria-describedby="helpEditPoster_url" value="{{$film->poster_url}}">
                                <small id="helpEditPoster_url" class="form-text text-muted">Only until the IMDB/RT ID works</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
                <hr>
                <!-- Create Director Modal -->
                <div id="create-director-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="create-director-modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="create-director-modal">Create Director</h5>
                                <button class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="director-name">Name of Director</label>
                                    <input id="director-name" class="form-control" type="text" name="name" autocomplete="off">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="create-director" type="submit" data-dismiss="modal" aria-label="Close" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Create Writer Modal -->          
                <div id="create-writer-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="create-writer-modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="create-writer-modal">Create Writer</h5>
                                <button class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="writer-name">Name of Writer</label>
                                    <input id="writer-name" class="form-control" type="text" name="name" autocomplete="off">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="create-writer" type="submit" data-dismiss="modal" aria-label="Close" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </div>
                </div>    
                <!-- Create Country Modal -->     
                <div id="create-country-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="create-country-modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="create-country-modal">Create Country</h5>
                                <button class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="country-name">Name of the Country</label>
                                    <input id="country-name" class="form-control" type="text" name="name" autocomplete="off">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="create-country" type="submit" data-dismiss="modal" aria-label="Close" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Delete Film Modal -->
                <div id="deleteFilmModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteFilmModal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteFilmModal">Delete Film</h5>
                                <button class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete the film?</p>
                                <h4>This will also delete all related reviews!</h4>
                            </div>
                            <form method="post" action="{{route('films.destroy', $film->id)}}">
                                @csrf
                                @method('DELETE')
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Delete Film</button>
                                </div>
                            </form>
                            @include('layouts.partials.errors')
                        </div>
                    </div>
                </div>
                @endauth
                <div id="film-info">
                    <!-- Done with AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('optional-scripts')
<script src="{{asset('js/film/film.js')}}"></script>
<script src="{{asset('js/review/review.js')}}"></script>
<script src="{{asset('js/film/form_functions.js')}}"></script>
<script src="{{asset('js/review/form_functions.js')}}"></script>
@endsection