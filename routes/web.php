<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/home', 'HomeController@index')->name('home');

// Main Routes

Route::get('/', 'MainController@index')->name('index');
Route::get('/about', 'MainController@about')->name('about');
Route::get('/stats', 'MainController@stats')->name('stats');
Route::get('/profile', 'MainController@profile')->name('profile')->middleware('auth');
Auth::routes();

// Reviews

Route::get('/reviews', 'ReviewController@index')->name('reviews.index')->middleware('auth'); // Probs Not Temporary
Route::get('/reviews/{review}', 'ReviewController@show')->name('reviews.show');
Route::post('/reviews', 'ReviewController@store')->name('reviews.store')->middleware('auth');
Route::put('/reviews/{review}', 'ReviewController@update')->name('reviews.update')->middleware('auth');
Route::delete('/reviews/{review}', 'ReviewController@destroy')->name('reviews.destroy')->middleware('auth');

// Films

Route::get('/films', 'FilmController@index')->name('films.index')->middleware('auth'); // Temporary
Route::get('/films/{film}', 'FilmController@show')->name('films.show');
Route::post('/films', 'FilmController@store')->name('films.store')->middleware('auth');
Route::put('/films/{film}', 'FilmController@update')->name('films.update')->middleware('auth');
Route::delete('/films/{film}', 'FilmController@destroy')->name('films.destroy')->middleware('auth');
Route::put('/films/{film}/watchlists', 'FilmController@editwatchlists')->name('films.editwatchlists')->middleware('auth');

// Names

Route::get('/names', 'NameController@index')->name('names.index')->middleware('auth'); // Temporary
Route::get('/names/{name}', 'NameController@show')->name('names.show');
Route::post('/names', 'NameController@store')->name('names.store')->middleware('auth');
Route::post('/names/ajax', 'NameController@ajax_store')->name('names.ajaxstore')->middleware('auth');
Route::put('/names/{name}', 'NameController@update')->name('names.update')->middleware('auth');
Route::delete('/names/{name}', 'NameController@destroy')->name('names.destroy')->middleware('auth');

// Countries

Route::get('/countries', 'CountryController@index')->name('countries.index')->middleware('auth'); // Temporary
Route::get('/countries/{country}', 'CountryController@show')->name('countries.show');
Route::post('/countries', 'CountryController@store')->name('countries.store')->middleware('auth');
Route::post('/countries/ajax', 'CountryController@ajax_store')->name('countries.ajaxstore')->middleware('auth');
Route::put('/countries/{country}', 'CountryController@update')->name('countries.update')->middleware('auth');
Route::delete('/countries/{country}', 'CountryController@destroy')->name('countries.destroy')->middleware('auth');

// Watchlists

Route::get('/watchlists', 'WatchlistController@index')->name('watchlists.index');
Route::get('/watchlists/{watchlist}', 'WatchlistController@show')->name('watchlists.show');
Route::post('/watchlists', 'WatchlistController@store')->name('watchlists.store')->middleware('auth');
Route::put('/watchlists/{watchlist}', 'WatchlistController@update')->name('watchlists.update')->middleware('auth');
Route::delete('/watchlists/{watchlist}', 'WatchlistController@destroy')->name('watchlists.destroy')->middleware('auth');
Route::put('/watchlists/{watchlist}/films', 'WatchlistController@editfilms')->name('watchlists.editfilms')->middleware('auth');

// Search

Route::get('/search/bar', 'SearchController@bar')->name('search.bar');
Route::get('/search/name', 'SearchController@name')->name('search.name');
Route::get('/search/country', 'SearchController@country')->name('search.country');
Route::get('/search/film', 'SearchController@film')->name('search.film');