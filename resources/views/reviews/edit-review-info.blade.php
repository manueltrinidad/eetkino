<form action="{{ route('reviews.update', $review->id)}}" method="post">
    <div class="modal-body">
        <div class="container-fluid">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" class="form-control" name="content" rows="12" required>{{$review->content}}</textarea>
            </div>
            <div id="add-film" class="form-group col">
                <label for="film_id">Film</label>
                <input id="search-bar-film" class="form-control" type="text" name="search-film" data-toggle="dropdown" autocomplete="off">
                <div class="dropdown-menu" id="search-film-dropdown" role="menu">
                </div>
            </div>
            <div class="form-group">
                <label for="review_date">Review Date</label>
                <input id="review_date" class="form-control" type="date" name="review_date" value="{{$review->review_date}}" required>
            </div>
            <div class="form-group">
                <label for="score">Score</label>
                <input id="score" class="form-control" type="number" name="score" value="{{$review->score}}" required>
            </div>
            <div class="form-group">
                <label for="is_draft">Is Draft?</label>
                <input id="is_draft" class="form-control" type="number" name="is_draft" value="{{$review->is_draft}}" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteReviewModal">Delete</a>
    </div>
</form>
@include('layouts.partials.errors')


<div id="deleteReviewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteReviewModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteReviewModal">Delete Review</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this review?</p>
            </div>
            <form method="post" action="{{route('reviews.destroy', $review->id)}}">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete Review</button>
                </div>
            </form>
            @include('layouts.partials.errors')
        </div>
    </div>
</div>