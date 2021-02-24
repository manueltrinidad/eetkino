<template id="t-about">
    <h1>A Very Restful Solution to Film Reviews</h1>
    <p>My forever-project to do some film reviews. Maybe will feature stats in the future.</p>
    <hr>
    <h4>Built using TMDb</h4>
</template>

<template id="t-user-info">
    <div id="user-info">
        <span>@{{ username }}</span>
        <input type="text" value="@{{ api_key }}" id="api-key" disabled>
        <a href="{{ url('/') }}" class="btn">Log Out</a>
    </div>
</template>

<template id="t-search-movies">
    @{{ #movies }}
    <div id="movie-search-@{{ tmdb_id }}" class="movie-cont" onclick="addMovieToReview('@{{ tmdb_id }}')" data-tmdb-id="@{{ tmdb_id }}" data-title="@{{ title }}" data-poster-path="@{{ poster_path }}">
        <b>@{{ title }}&nbsp;</b>(@{{ year }})
    </div>
    @{{ /movies }}
</template>

<template id="t-review-form">
    <div id="review-cont">
        <form action="{{ url('/api/v1/review/store') }}" id="review-form" method="post">
            <div>
                <label for="score-input">Score</label>
                <input type="number" name="score" id="score-input" max="100" min="0" class="review-input" required>
                <label for="watch-date-input">Watch Date</label>
                <input type="date" name="watch_date" id="watch-date-input" class="review-input">
                <input type="text" name="tmdb_id" id="tmdb-id-input" class="hide" disabled required>
                <button type="submit" class="btn">Submit</button>
            </div>
            <span id="movie-title-input" class="movie-cont"></span>
            <label for="comment-input">Review Comment</label>
            <textarea name="comment" id="comment-input" cols="60" rows="12"></textarea>
        </form>
        <div id="movies-search-cont">
            <input type="text" onkeyup="doSearch(this.value)" name="q" id="q" placeholder="Search" class="review-input">
            <div id="movies-search"></div>
        </div>
    </div>
</template>
