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

Route::get('auth/facebook',          'Auth\AuthController@redirectToProvider')->name('fb.auth');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback')->name('fb.callback');

Route::resource('songs',  'SongController');
Route::resource('shows',  'ShowController');
Route::resource('albums', 'AlbumController');

Route::get('data/songs', 'DataController@songs')->name('data.songs');

Route::post(  'shows/{show}/notes',        'ShowController@storeNote')->name('show.notes.store');
Route::delete('shows/{show}/notes/{note}', 'ShowController@destroyNote')->name('show.notes.destroy');

Route::post('albums/{album}/notes', 'AlbumController@storeNote')->name('albums.notes.store');
Route::delete('albums/{album}/notes/{note}', 'AlbumController@destroyNote')->name('albums.notes.destroy');

Route::post('songs/{song}/notes', 'SongController@storeNote')->name('songs.notes.store');
Route::delete('songs/{song}/notes/{note}', 'SongController@destroyNote')->name('songs.notes.destroy');

Route::get('plays', 'SongController@findPlays')->name('songs.plays.find');
Route::get('songs/{song}/plays', 'SongController@showPlays')->name('songs.plays.show');

Route::get('stats/{username}/songs/{song}/plays', 'UserController@showPlays')->name('users.songs.plays.show');

Route::post(  'setlistitems/{item}/video',         'ShowController@storeVideo')->name('show.video.store');
Route::delete('setlistitems/{item}/video/{video}', 'ShowController@destroyVideo')->name('show.video.destroy');

Route::post('albumitems/{item}/note', 'AlbumController@storeItemNote')->name('albums.itemnote.store');
Route::delete('albumitems/{item}/note/{note}', 'AlbumController@destroyItemNote')->name('albums.itemnote.destroy');

Route::get('admin',       'AdminController@index')->name('admin.index');
Route::get('admin/audit', 'AdminController@audit')->name('admin.audit');
Route::get('admin/users', 'AdminController@users')->name('admin.users');

Route::put('songs/{song}/notes/{note}', 'SongController@updateNote')->name('songs.note.update');
Route::put('shows/{show}/notes/{note}', 'ShowController@updateNote')->name('shows.note.update');
Route::put('setlistitems/{item}/video/{video}', 'ShowController@approveVideo')->name('show.video.approve');

Route::put('albums/{album}/notes/{note}', 'AlbumController@updateNote')->name('albums.note.update');
Route::put('albumitems/{item}/video/{video}', 'AlbumController@approveItemNote')->name('albums.itemnote.approve');

Route::get('stats/{username}',        'UserController@userstats')->name('user.stats');
Route::get('stats/{username}/shows',  'UserController@shows')->name('user.shows');
Route::get('stats/{username}/songs',  'UserController@songs')->name('user.songs');
Route::get('stats/{username}/albums', 'UserController@albums')->name('user.albums');

Route::get('stats', 'UserController@allstats')->name('user.index');

Route::post(  'users/shows/{show_id}', 'UserController@storeShow')->name('user.show.store');
Route::delete('users/shows/{show_id}', 'UserController@destroyShow')->name('user.show.destroy');

Route::get('settings',        'UserController@settings')->name('user.settings');
Route::put('settings/update', 'UserController@update')->name('user.update.store');

Route::get('privacy', function() {
    return view('privacy');
});

Route::get('about', function() {
    return view('about');
});