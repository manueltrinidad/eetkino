<div id="editFilmsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editFilmsModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFilmsModal">Remove Movies</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('watchlists.editfilms', $watchlist->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @foreach ($watchlist->films as $film)
                    <input type="checkbox" name="films[]" id="films" value="{{$film->id}}" checked="checked">
                    {{$film->title_english}}
                    <br>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Remove Movies</button>
                </div>
            </form>
        </div>
    </div>
</div>