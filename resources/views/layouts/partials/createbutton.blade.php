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
                            <a href="#createName" class="nav-link active" data-toggle="tab" role="tab" aria-controls="name" aria-selected="true">
                                Name
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#createCountry" class="nav-link" data-toggle="tab" role="tab" aria-controls="name" aria-selected="true">
                                Country
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="createTabsContent">
                        <!-- Create Name -->
                        <div class="tab-pane fade show active" id="createName" role="tabpanel" aria-labelledby="name-tab">
                            <br>
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
                            <br>
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