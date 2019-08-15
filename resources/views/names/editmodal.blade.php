<!-- Edit Name Modal -->

<div id="editNameModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editNameModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNameModal">Edit Name</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{route('names.update', $name->id)}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" class="form-control" type="text" name="name" value="{{$name->name}}" required>
                    </div>
                </div>
                @csrf
                @method('PUT')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Edit Name</button>
                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteNameModal">Delete</a>
                </div>
            </form>
            @include('layouts.partials.errors')
        </div>
    </div>
</div>

<!-- Delete Name Modal -->

<div id="deleteNameModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteNameModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteNameModal">Delete Name</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the name?</p>
            </div>
            <form method="post" action="{{route('names.destroy', $name->id)}}">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete Name</button>
                </div>
            </form>
            @include('layouts.partials.errors')
        </div>
    </div>
</div>