@extends('layouts.app')
@section('title', $title)
@section('content')
    <nav id="navbar">
        <a id="home-link" href="{{ url('/') }}">EETKINO</a>
        <form id="login-form" action="{{ url("/api/v1/user/auth") }}" method="get">
            @if(env('USER_REGISTRATION'))
            <div id="signup-btn" class="btn">Sign Up</div>
            <span>or</span>
            @endif
            <label for="api-key">
                <input id="api-key" type="text" name="api_key" placeholder="Your API Key">
            </label>
            <button type="submit" class="btn">Login</button>
        </form>
    </nav>
    @if(env('USER_REGISTRATION'))
    <div class="hide" id="signup-form-cont">
        <h2>Sign Up</h2>
        <p>Enter your details below to get an API key.</p>
        <form id="signup-form" action="{{ url("/api/v1/user/register") }}" method="post">
            <label for="username-signup">
                Username
                <input type="text" name="username" id="username-signup">
            </label>
            <label for="email-signup">
                Email
                <input type="text" name="email" id="email-signup">
            </label>
            <label for="password-signup">
                Password
                <input type="password" name="password" id="password-signup">
            </label>
            <label for="confirm-password-signup">
                Confirm Password
                <input type="password" name="password_confirmation" id="confirm-password-signup">
            </label>
            <button class="btn" type="submit">Submit</button>
        </form>
        <div id="new-api-key"></div>
    </div>
    @endif
    <div id="container">
        <div id="about"></div>
    </div>

    @include('templates.index')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mustache@4.1.0/mustache.min.js"></script>
    <script src="{{ url('js/jquery.toast.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            let temp = $("#t-about").html();
            let out = Mustache.render(temp);
            $("#about").append(out);

            @if(env('USER_REGISTRATION'))
            $('#signup-btn').click(function () {
                $("#signup-form-cont").toggleClass("hide");
            });
            $("#signup-form").on("submit", function (f) {
                let url = $(this).attr('action');
                f.preventDefault();
                $.ajax({
                    method: "POST",
                    url: url,
                    data: $("#signup-form").serialize(),
                    dataType: 'json',
                    statusCode: {
                        201: function (e) {
                            let newApiKeyDiv = $("#new-api-key");
                            newApiKeyDiv.empty();
                            newApiKeyDiv.append(e.api_key);
                        },
                        400: function (e) {

                            let errorsArray = validateErrorsToArray(e.responseJSON.errors);
                            showErrors(errorsArray);
                        },
                        401: function () {
                            showErrors("Registration is Disabled", "Unauthorized");
                        },
                        500: function () {
                            showErrors("Internal server error, try again later.");
                        }
                    }
                });
            });
            @endif

            $("#login-form").on("submit", function (f) {
                let url = $(this).attr('action');
                f.preventDefault();
                $.ajax({
                    method: "GET",
                    url: url,
                    data: $("#login-form").serialize(),
                    dataType: 'json',
                    statusCode: {
                        200: function (e) {
                            renderUserDashboard(e);
                        },
                        401: function () {
                            showErrors("Unauthorized", "Forbidden");
                        }
                    }
                });
            });

        });

        function validateErrorsToArray(errorsObj)
        {
            let final = [];
            Object.values(errorsObj).forEach(function (field) {
                field.forEach(function (error) {
                    final.push(error);
                });
            });
            return final;
        }

        function showErrors(errorsArray, heading = "There was an error")
        {
            $.toast({
                heading: heading,
                text: errorsArray,
                position: 'top-right',
                stack: false,
                hideAfter: 5000,
                loader: false,
                bgColor: "#b03434"
            });
        }

        function renderUserDashboard(userInfo)
        {
            userInfo.api_key = $('#api-key').val();
            $("#about").remove();
            $('#login-form').remove();
            @if(env('USER_REGISTRATION'))
            $('#signup-form-cont').remove();
            @endif
            // Render Search bar + api key
            let temp = $("#t-user-info").html();
            let out = Mustache.render(temp, userInfo);
            $("#navbar").append(out);

            // Render Review Form
            temp = $('#t-review-form').html();
            out = Mustache.render(temp);
            $("#container").append(out);
        }

        var testDelayTimer;
        function doSearch()
        {
            const testData = [{"tmdb_id":862,"title":"Toy Story","release_date":"1995-10-30","poster_path":"\/uXDfjJbdP4ijW5hWSBrPrlKpxab.jpg"},{"tmdb_id":301528,"title":"Toy Story 4","release_date":"2019-06-19","poster_path":"\/w9kR8qbmQ01HwnvK4alvnQ2ca0L.jpg"},{"tmdb_id":863,"title":"Toy Story 2","release_date":"1999-10-30","poster_path":"\/eVGu0zsezaSCuN67zgNhzjeNI9Z.jpg"},{"tmdb_id":10193,"title":"Toy Story 3","release_date":"2010-06-16","poster_path":"\/4cpGytCB0eqvRks4FAlJoUJiFPG.jpg"},{"tmdb_id":256835,"title":"Toy Story That Time Forgot","release_date":"2014-12-02","poster_path":"\/pw1YgzcBw4GmwylrFlXMzLdELRo.jpg"},{"tmdb_id":464729,"title":"The Story Behind 'Toy Story'","release_date":"1996-12-18","poster_path":"\/rOaeh83eylKNBkPxUMAUAogb7rS.jpg"},{"tmdb_id":210296,"title":"Charlie: A Toy Story","release_date":"2013-04-02","poster_path":"\/pNwY2CctdBb464VKKslOe7c0A1R.jpg"},{"tmdb_id":786568,"title":"Toy Story 3 in Real Life","release_date":"2020-01-25","poster_path":"\/onYmmHW6B7gVA1CvUUf7ONTXLgj.jpg"},{"tmdb_id":711704,"title":"The Making of 'Toy Story'","release_date":"1995-12-02","poster_path":"\/oTQlHuKQawozyEgzI7bebX8BYLG.jpg"},{"tmdb_id":757564,"title":"Child\u2018s Play: Toy Story Massacre","release_date":"2019-06-21","poster_path":"\/deDtKqy96tkrnVXzIJWLldaz1H6.jpg"},{"tmdb_id":213121,"title":"Toy Story of Terror!","release_date":"2013-10-16","poster_path":"\/oPBEnNP4Fg4gv9c0KBhchmtoG4H.jpg"},{"tmdb_id":406122,"title":"Toy Story at 20: To Infinity and Beyond","release_date":"2015-12-10"},{"tmdb_id":626033,"title":"Toy Story 3: Na Moda com Ken!","release_date":"2010-08-30","poster_path":"\/3dMsdWPDSW7USlexiDMjquoF7HU.jpg"},{"tmdb_id":431575,"title":"The Rogue One: A Star Wars Toy Story","release_date":"2016-12-15"},{"tmdb_id":82424,"title":"Small Fry","release_date":"2011-11-23","poster_path":"\/8siICxMft0JSWZDq9YrXh5U5PZx.jpg"},{"tmdb_id":77887,"title":"Hawaiian Vacation","release_date":"2011-06-16","poster_path":"\/yoNUZR5gFwJ822HSzcIr6y1wk1G.jpg"},{"tmdb_id":130925,"title":"Partysaurus Rex","release_date":"2012-09-14","poster_path":"\/7Y7NBliUme8KFqBh4MvQ1NOSDNW.jpg"}];
            clearTimeout(testDelayTimer);
            renderSearchMovies({"movies": testData});
        }

        var delayTimer;
        function doSearch_bu() {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {
                let url = "{{ url('/api/v1/movie/search') }}";
                $.ajax({
                    method: "GET",
                    url: url,
                    data: {
                        "api_key": $('#api-key').val(),
                        "q": $("#q").val()
                    },
                    dataType: 'json',
                    statusCode: {
                        200: function (e) {
                            renderSearchMovies({"movies": e});
                        },
                        400: function (e) {
                            let errorsArray = validateErrorsToArray(e.responseJSON.errors);
                            showErrors(errorsArray);
                        },
                        401: function () {
                            showErrors("Invalid API key", "Unauthorized");
                        }
                    }
                });
            }, 1000);
        }

        function renderSearchMovies(movies)
        {
            $('#movies-search').empty();
            for (let i = 0; i < movies.movies.length; i++)
            {
                movies.movies[i].year = new Date(movies.movies[i].release_date).getFullYear();
                console.log(movies.movies[i]);
            }

            let temp = $("#t-search-movies").html();
            let out = Mustache.render(temp, movies);
            $("#movies-search").append(out);
        }

        function addMovieToReview(tmdb_id)
        {
            let divData = $('#movie-search-'+tmdb_id);
            let movieTitleDiv = $('#movie-title-input');
            movieTitleDiv.empty();
            movieTitleDiv.append(divData.data('title'));
            let tmdbIdInput = $('#tmdb-id-input');
            tmdbIdInput.empty();
            tmdbIdInput.val(tmdb_id);
            $('#movies-search').empty();
        }
    </script>
@endsection
