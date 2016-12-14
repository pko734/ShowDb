<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('index');
});

Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider')->name('fb.auth');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback')->name('fb.callback');

Route::resource('songs', 'SongController');

Route::resource('shows', 'ShowController');

Route::get('data/songs', 'DataController@songs')->name('data.songs');

Route::post('shows/{show}/notes', 'ShowController@storeNote')->name('show.notes.store');
Route::delete('shows/{show}/notes/{note}', 'ShowController@destroyNote')->name('show.notes.destroy');

Route::post('songs/{song}/notes', 'SongController@storeNote')->name('song.notes.store');
Route::delete('songs/{song}/notes/{note}', 'SongController@destroyNote')->name('song.notes.destroy');

Route::get('plays', 'SongController@findPlays')->name('song.plays.find');
Route::get('songs/{song}/plays', 'SongController@showPlays')->name('song.plays.show');

Route::post('setlistitems/{item}/video', 'ShowController@storeVideo')->name('show.video.store');
Route::delete('setlistitems/{item}/video/{video}', 'ShowController@destroyVideo')->name('show.video.destroy');

Route::get('admin', 'AdminController@index')->name('admin.index');

Route::put('songs/{song}/notes/{note}', 'SongController@approveNote')->name('song.note.approve');
Route::put('shows/{show}/notes/{note}', 'ShowController@approveNote')->name('show.note.approve');
Route::put('setlistitems/{item}/video/{video}', 'ShowController@approveVideo')->name('show.video.approve');


Route::get('about', function() {
    return view('about');
});