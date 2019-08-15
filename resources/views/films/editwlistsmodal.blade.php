<div id="editWatchlistModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editWatchlistModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWatchlistModal">Add to Watchlist</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('films.editwatchlists', $film)}}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @foreach ($watchlists as $watchlist)
                    <?php $in_wlist = 0 ?>
                    @foreach ($watchlist->films as $filmw)
                    @if ($filmw->id == $film->id)
                    <?php $in_wlist = 1 ?>
                    <input type="checkbox" name="watchlists[]" id="watchlists" value="{{$watchlist->id}}" checked="checked">
                    @endif
                    @endforeach
                    @if ($in_wlist == 0)
                    <input type="checkbox" name="watchlists[]" id="watchlists" value="{{$watchlist->id}}">
                    @endif
                    {{$watchlist->title}}
                    <br>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>