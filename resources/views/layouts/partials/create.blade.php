@auth
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary create-btn" data-toggle="modal" data-target="#createModal">
    Create
</button>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create an Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <ul class="nav nav-tabs" role="tablist" id="createTabs">
                        <li class="nav-item">
                            <a href="#createReview" class="nav-link active" data-toggle="tab" role="tab" aria-controls="review" aria-selected="true">
                                Review
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#createMovie" class="nav-link" data-toggle="tab" role="tab" aria-controls="movie" aria-selected="true">
                                Movie
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#createName" class="nav-link" data-toggle="tab" role="tab" aria-controls="name" aria-selected="true">
                                Name
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#createCountry" class="nav-link" data-toggle="tab" role="tab" aria-controls="name" aria-selected="true">
                                Country
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#createWatchlist" class="nav-link" data-toggle="tab" role="tab" aria-controls="name" aria-selected="true">
                                Watchlist
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="createTabsContent">
                        <!-- Create Review -->
                        <div class="tab-pane fade show active" id="createReview" role="tabpanel" aria-labelledby="review-tab">
                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="review_date">Review Date</label>
                                        <input type="date"
                                        class="form-control" name="review_date" id="review_date" placeholder="Review Date" required>
                                    </div>
                                    <div class="form-group col">
                                        <label for="film_id">Film</label>
                                        <input type="text" name="film_id" id="film_id" class="form-control" placeholder="Film ID" aria-describedby="helpFilmId">
                                        <small id="helpFilmId" class="text-muted">ID for now</small>
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
                        <div class="tab-pane fade" id="createMovie" role="tabpanel" aria-labelledby="movie-tab">
                            <form action="{{ route('films.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="title_english">Title</label>
                                    <input type="text"
                                    class="form-control" name="title_english" id="title_english" aria-describedby="helpTitleEnglish" placeholder="Title" required>
                                    <small id="helpTitleEnglish" class="form-text text-muted">Title of the movie in english</small>
                                </div>
                                <div class="form-group">
                                    <label for="title_native">Native Title</label>
                                    <input type="text"
                                    class="form-control" name="title_native" id="title_native" aria-describedby="helpTitleNative" placeholder="Native title">
                                    <small id="helpTitleNative" class="form-text text-muted">Title of the movie in its native language.</small>
                                </div>
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="directors">Director(s)</label>
                                        <input type="text"
                                        class="form-control" name="directors" id="directors" aria-describedby="helpDirectors" placeholder="Director(s)" required>
                                        <small id="helpDirectors" class="form-text text-muted">For now input ID's comma divided.</small>
                                    </div>
                                    <div class="form-group col">
                                        <label for="writers">Writer(s)</label>
                                        <input type="text"
                                        class="form-control" name="writers" id="writers" aria-describedby="helpWriters" placeholder="Writer(s)" required>
                                        <small id="helpWriters" class="form-text text-muted">For now input ID's comma divided.</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="countries">Country of Production</label>
                                        <input type="text"
                                        class="form-control" name="countries" id="countries" aria-describedby="helpCountries" placeholder="Country" required>
                                        <small id="helpCountries" class="form-text text-muted">
                                            For now input ID's comma divided. Also place them era-wise. Ex. East Germany.
                                        </small>
                                    </div>
                                    <div class="form-group col">
                                        <label for="release_date">Release Date</label>
                                        <input type="date"
                                        class="form-control" name="release_date" id="release_date" placeholder="Release Date" required>
                                    </div>
                                    <div class="form-group col">
                                        <label for="film_type">Type of Media</label>
                                        <select name="film_type" class="form-control" id="film_type" aria-describedby="helpFilmType" required>
                                            <option value="film">Film</option>
                                            <option value="short">Short Film</option>
                                            <option value="series">Series Episode</option>
                                        </select>
                                        <small id="helpFilmType" class="form-text text-muted">Is this a Film, Short or Series?</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col">
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
                        <!-- Create Name -->
                        <div class="tab-pane fade" id="createName" role="tabpanel" aria-labelledby="name-tab">
                            <form action="{{ route('names.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Known Name</label>
                                    <input type="text"
                                    class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="Woody Allen" required>
                                    <small id="Name" class="form-text text-muted">Display one</small>
                                </div>
                                <button type="submit" class="btn btn-primary">Create Name</button>
                            </form>
                            @include('layouts.partials.errors')
                        </div>
                        <!-- Create Country -->
                        <div class="tab-pane fade" id="createCountry" role="tabpanel" aria-labelledby="name-tab">
                            <form action="{{ route('countries.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Country Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Japan" aria-describedby="helpName" required>
                                    <small id="helpName" class="text-muted">English name relevant to the time. Ex. East Germany vs Germany.</small>
                                </div>
                                <button type="submit" class="btn btn-primary">Create Country</button>
                            </form>
                            @include('layouts.partials.errors')
                        </div>
                        <!-- Create Watchlist -->
                        <div class="tab-pane fade" id="createWatchlist" role="tabpanel" aria-labelledby="name-tab">
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
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#createModal').on('show.bs.modal', event => {
        var button = $(event.relatedTarget);
        var modal = $(this);
        // Use above variables to manipulate the DOM
    });
</script>
@endauth