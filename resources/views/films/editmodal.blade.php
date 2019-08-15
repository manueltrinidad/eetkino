<!-- Edit Film Modal -->
<div class="modal fade" id="editFilmModal" tabindex="-1" role="dialog" aria-labelledby="editFilmModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Film</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('films.update', $film->id)}}" method="post">
                <div class="modal-body">
                    <div class="container-fluid">
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
                        {{-- This whole thing will change once I do AJAX inputs --}}
                        <?php $directors = $writers = $countries = array();?>
                        
                        @foreach ($film->names as $name)
                        @if ($name->pivot->credit == 'director')
                        <?php array_push($directors, $name->id)?>
                        @elseif ($name->pivot->credit == 'writer')
                        <?php array_push($writers, $name->id)?>
                        @endif
                        @endforeach
                        
                        @foreach ($film->countries as $country)
                        <?php array_push($countries, $country->id)?>
                        @endforeach
                        {{-- End of the whole thing --}}
                        <div class="form-group">
                            <label for="directors">Directors</label>
                            <input type="text" name="directors" id="directors" class="form-control" aria-describedby="helpEditDirectors" value="{{implode(',', $directors)}}" required>
                            <small id="helpEditDirectors" class="text-muted">Director IDs</small>
                        </div>
                        <div class="form-group">
                            <label for="writers">Writers</label>
                            <input type="text" name="writers" id="writers" class="form-control" aria-describedby="helpEditWriters" value="{{implode(',', $writers)}}" required>
                            <small id="helpEditWriters" class="text-muted">Writer IDs</small>
                        </div>
                        <div class="form-group">
                            <label for="countries">Country of Production</label>
                            <input type="text"
                            class="form-control" name="countries" id="countries" aria-describedby="helpEditCountries" value="{{implode(',', $countries)}}" required>
                            <small id="helpEditCountries" class="form-text text-muted">
                                For now input ID's comma divided. Also place them era-wise. Ex. East Germany.
                            </small>
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
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="imdb_id">IMDB ID</label>
                                <input type="text" class="form-control" name="imdb_id" id="imdb_id" aria-describedby="helpEditImdb_id" value="{{$film->imdb_id}}">
                                <small id="helpEditImdb_id" class="form-text text-muted">Format is usually 'tt...'</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="poster_url">Poster URL (provitional)</label>
                            <input type="text" class="form-control" name="poster_url" id="poster_url" aria-describedby="helpEditPoster_url" value="{{$film->poster_url}}">
                            <small id="helpEditPoster_url" class="form-text text-muted">Only until the IMDB/RT ID works</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteFilmModal">Delete</a>
                </div>
            </form>
            @include('layouts.partials.errors')
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