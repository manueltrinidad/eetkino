<!-- Edit Watchlist Modal -->

<div id="editWatchlistModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editWatchlistModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWatchlistModal">Edit Watchlist</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('watchlists.update', $watchlist->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input id="title" class="form-control" type="text" name="title" value="{{$watchlist->title}}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input id="description" class="form-control" type="text" name="description" value="{{$watchlist->description}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteWatchlistModal">Delete</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Watchlist Modal -->

<div id="deleteWatchlistModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteWatchlistModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteWatchlistModal">Delete Watchlist</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{route('watchlists.destroy', $watchlist->id)}}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Are you sure you want to delete the watchlist?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>