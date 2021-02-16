# EETKINO

EETKINO is a REST web API to review films. It is powered by [Lumen](https://lumen.laravel.com/) and makes use of [TMDb's API](https://www.themoviedb.org/documentation/api) to retrieve Films, Cast and Crew. It populates a local database dynamically with the films reviewed by each user.

## Requirements

The installation process can be found [here](https://lumen.laravel.com/docs/8.x/installation). You will need a TMDb API key as well. The Database layer works perfectly with MySQL and hasn't been tested under any other DBMS.

## Environment

All environment variables must be set under `.env`. `USER_REGISTRATION` refers to the ability to register new users. `MAX_CAST` refers to the maximum amount of cast members that can be retrieved per film. 

## Endpoints

Please check `routes/web.php` for all the endpoints possible until I get Swagger running on it. The data for each endpoint can be gathered from the `validation` in the `Service Layer` of each `Controller` method.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

