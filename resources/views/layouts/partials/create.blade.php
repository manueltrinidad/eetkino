@auth
<br>
<h4>Create New Item</h4>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link" id="create-review-tab" data-toggle="tab" href="#create-review" role="tab" aria-controls="create-review" aria-selected="false">Review</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="create-movie-tab" data-toggle="tab" href="#create-movie" role="tab" aria-controls="create-movie" aria-selected="false">Movie</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="create-watchlist-tab" data-toggle="tab" href="#create-watchlist" role="tab" aria-controls="create-watchlist" aria-selected="false">Watchlist</a>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    
    <!-- Create Review -->
    <div class="tab-pane fade" id="create-review" role="tabpanel" aria-labelledby="create-review-tab">
        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col">
                    <label for="review_date">Review Date</label>
                    <input type="date"
                    class="form-control" name="review_date" id="review_date" placeholder="Review Date" required>
                </div>
                <div id="add-film" class="form-group col">
                    <label for="film_id">Film</label>
                    <input id="search-bar-film" class="form-control" type="text" name="search-film" data-toggle="dropdown" autocomplete="off">
                    <div class="dropdown-menu" id="search-film-dropdown" role="menu">
                    </div>
                </div>
                <div class="form-group col">
                    <label for="score">Score</label>
                    <input type="number" name="score" id="score" class="form-control" placeholder="Score" aria-describedby="helpScore" required>
                </div>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea rows="12" name="content" id="content" class="form-control" placeholder="Write review here"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="is_draft" value="0">Publish</button>
            <button type="submit" class="btn btn-primary" name="is_draft" value="1">Save Draft</button>
        </form>
        @include('layouts.partials.errors')
    </div>
    
    <!-- Create Movie -->
    <div class="tab-pane fade" id="create-movie" role="tabpanel" aria-labelledby="create-movie-tab">
        <form action="{{ route('films.store') }}" method="POST" autocomplete="off">
            <br>
            @csrf
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="title_english">Title</label>
                    <input type="text"
                    class="form-control" name="title_english" id="title_english" aria-describedby="helpTitleEnglish" placeholder="Title" required>
                    <small id="helpTitleEnglish" class="form-text text-muted">Title of the movie in english</small>
                </div>
                <div class="form-group col-sm-6">
                    <label for="title_native">Native Title</label>
                    <input type="text"
                    class="form-control" name="title_native" id="title_native" aria-describedby="helpTitleNative" placeholder="Native title">
                    <small id="helpTitleNative" class="form-text text-muted">Title of the movie in its native language.</small>
                </div>
            </div>
            <hr>
            <div class="row">
                <div id="add-director" class="form-group col-sm-4">
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
                <div id="add-writer" class="form-group col-sm-4">
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
                <div id="add-country" class="form-group col-sm-4">
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
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="release_date">Release Date</label>
                    <input type="date"
                    class="form-control" name="release_date" id="release_date" placeholder="Release Date" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="film_type">Type of Media</label>
                    <select name="film_type" class="form-control" id="film_type" aria-describedby="helpFilmType" required>
                        <option value="film">Film</option>
                        <option value="short">Short Film</option>
                        <option value="series">Series Episode</option>
                    </select>
                    <small id="helpFilmType" class="form-text text-muted">Is this a Film, Short or Series?</small>
                </div>
                <div class="form-group col-sm-4">
                    <label for="imdb_id">IMDB ID</label>
                    <input type="text" class="form-control" name="imdb_id" id="imdb_id" aria-describedby="helpImdb_id" placeholder="IMDB ID">
                    <small id="helpImdb_id" class="form-text text-muted">Format is usually 'tt...'</small>
                </div>
            </div>
            <div class="form-group">
                <label for="poster_url">Poster URL (provitional)</label>
                <input type="text" class="form-control" name="poster_url" id="poster_url" aria-describedby="helpPoster_url" placeholder="Poster URL">
                <small id="helpPoster_url" class="form-text text-muted">Only until the IMDB/RT ID works</small>
            </div>
            <button type="submit" class="btn btn-primary">Create New Movie</button>
        </form>
        @include('layouts.partials.errors')
    </div>
    
    <!-- Create Watchlist -->
    <div class="tab-pane fade" id="create-watchlist" role="tabpanel" aria-labelledby="create-watchlist-tab">
        <form action="{{ route('watchlists.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Best movies ever!" aria-describedby="helpTitle" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input id="description" class="form-control" type="text" name="description" placeholder="All of them!">
            </div>
            <button type="submit" class="btn btn-primary">Create Watchlist</button>
        </form>
        @include('layouts.partials.errors')
    </div>
    
</div>


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

@endauth