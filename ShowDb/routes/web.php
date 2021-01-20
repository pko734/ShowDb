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

Route::view('offline', 'offline');

#Route::get('/', function (Request $request) {
#    if (Auth::user()) {
#        return view('redirect')->withTo('stats/'.Auth::user()->username);
#
#        return redirect('stats/'.Auth::user()->username);
#    } else {
#        return view('redirect')->withTo('login');
#
#        return redirect('register');
#   }
#});

Route::get('/', 'IndexController@index');


Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider')->name('fb.auth');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback')->name('fb.callback');

// fantasy shows
//Route::resource('fantasy/shows',                     'FantasyShowController', ['as' =>'fantasy']);
//Route::get(     'fantasy',                           'FantasyShowController@list')->name('fantasy.shows.list');
//Route::post(    'fantasy/shows/{show}/notes',        'FantasyShowController@storeNote')->name('fantasy.show.notes.store');
//Route::delete(  'fantasy/shows/{show}/notes/{note}', 'FantasyShowController@destroyNote')->name('fantasy.show.notes.destroy');
//Route::put(     'fantasy/shows/{show}/notes/{note}', 'FantasyShowController@updateNote')->name('fantasy.shows.note.update');

// songs
Route::resource('songs', 'SongController');
Route::post('songs/{song}/notes', 'SongController@storeNote')->name('songs.notes.store');
Route::delete('songs/{song}/notes/{note}', 'SongController@destroyNote')->name('songs.notes.destroy');
Route::put('songs/{song}/notes/{note}', 'SongController@updateNote')->name('songs.note.update');
Route::get('songs/{song}/plays', 'SongController@showPlays')->name('songs.plays.show');
Route::get('data/songs', 'DataController@songs')->name('data.songs');
Route::get('plays', 'SongController@findPlays')->name('songs.plays.find');

// shows
Route::resource('shows', 'ShowController');
Route::post('shows/{show}/notes', 'ShowController@storeNote')->name('show.notes.store');
Route::delete('shows/{show}/notes/{note}', 'ShowController@destroyNote')->name('show.notes.destroy');
Route::put('shows/{show}/notes/{note}', 'ShowController@updateNote')->name('shows.note.update');
Route::post('setlistitems/{item}/video', 'ShowController@storeItemNote')->name('show.itemnote.store');
Route::delete('setlistitems/{item}/video/{video}', 'ShowController@destroyItemNote')->name('show.itemnote.destroy');
Route::put('setlistitems/{item}/video/{video}', 'ShowController@approveItemNote')->name('show.itemnote.approve');
Route::post('user/shows/{show_id}', 'UserController@storeShow')->name('user.show.store');
Route::delete('user/shows/{show_id}', 'UserController@destroyShow')->name('user.show.destroy');

Route::post('shows/{show}/upload', 'ShowController@uploadImagePost')->name('show.image.upload');
Route::delete('shows/{show}/photos/{photo}', 'ShowController@deleteImagePost')->name('show.image.delete');
Route::put('shows/{show}/photos/{photo}', 'ShowController@approvePhoto')->name('show.image.approve');

Route::get('data/states', 'DataController@states')->name('data.states');

// albums
Route::resource('albums', 'AlbumController');
Route::post('albums/{album}/notes', 'AlbumController@storeNote')->name('albums.notes.store');
Route::delete('albums/{album}/notes/{note}', 'AlbumController@destroyNote')->name('albums.notes.destroy');
Route::put('albums/{album}/notes/{note}', 'AlbumController@updateNote')->name('albums.note.update');
Route::post('albumitems/{item}/note', 'AlbumController@storeItemNote')->name('albums.itemnote.store');
Route::delete('albumitems/{item}/note/{note}', 'AlbumController@destroyItemNote')->name('albums.itemnote.destroy');
Route::put('albumitems/{item}/note/{note}', 'AlbumController@approveItemNote')->name('albums.itemnote.approve');

// merch
Route::get('merch', 'MerchController@index');
Route::get('merch/create', 'MerchController@create');
Route::get('merch/stickers', 'MerchController@stickers');
Route::get('merch/patches', 'MerchController@patches');
Route::get('merch/skatedecks', 'MerchController@skateDecks');
Route::get('merch/hats', 'MerchController@hats');
Route::get('merch/bandanas', 'MerchController@bandanas');
Route::get('merch/beltbuckles', 'MerchController@beltBuckles');
Route::get('merch/posters', 'MerchController@posters');
Route::get('merch/vinyl', 'MerchController@vinyl');
Route::get('merch/cds', 'MerchController@cds');
Route::get('merch/misc', 'MerchController@misc');
Route::get('merch/pinsandbuttons', 'MerchController@pinsAndButtons');
Route::get('merch/tshirts', 'MerchController@tshirts');
Route::get('merch/jacketsandsweatshirts', 'MerchController@jacketsAndSweatshirts');

Route::get('merch/{unknown}', function($x) {abort(404);});

Route::post('user/merch/{merch_id}', 'UserController@storeMerch')->name('user.merch.store');
Route::delete('user/merch/{merch_id}', 'UserController@destroyMerch')->name('user.merch.destroy');

Route::get('merch/{merch}/edit', 'MerchController@edit');
Route::put('merch/{merch}', 'MerchController@update');
Route::delete('merch/{merch}', 'MerchController@destroy');
Route::post('merch', 'MerchController@store');

Route::get('madness', function() {
    return view('bracket/2020');
});

// stats
Route::get('stats', 'UserController@allstats')->name('user.index');
Route::get('stats/all/songs', 'UserController@songsAll')->name('songs.all');
Route::get('stats/all/songs/{song}/plays', 'UserController@showPlaysAll')->name('users.songs.plays.all.show');
Route::get('stats/{username}/songs/{song}/plays', 'UserController@showPlays')->name('users.songs.plays.show');
Route::get('stats/{username}', 'UserController@userstats')->name('user.stats');
Route::get('stats/{username}/shows', 'UserController@shows')->name('user.shows');
Route::get('stats/{username}/songs', 'UserController@songs')->name('user.songs');
Route::get('stats/{username}/albums', 'UserController@albums')->name('user.albums');
Route::get('stats/{username}/timeline', 'UserController@timeline')->name('user.timeline');

// users
Route::get('users', 'UsersController@index')->name('users.index');

// admin
Route::get('admin', 'AdminController@index')->name('admin.index');
Route::get('admin/audit', 'AdminController@audit')->name('admin.audit');
Route::get('admin/users', 'AdminController@users')->name('admin.users');
Route::post('admin/users/{user_id}/toggle-donor', 'AdminController@toggleDonor')->name('admin.toggleDonor');

// trivia admin
Route::resource('admin/trivia', 'AdminTriviaController');
Route::get('data/trivia', 'DataController@trivia')->name('data.trivia');
Route::get('data/triviaAuth', 'DataController@triviaAuth')->name('data.triviaAuth');

// games
Route::get('game', 'GameController@index')->name('game.index');

// trivia
Route::resource('trivia', 'TriviaController');

// timeline admin
Route::resource('admin/timeline', 'AdminTimelineController');

// timeline
Route::get('timeline', 'TimelineController@index')->name('timeline.index');

// what's new
Route::get('new', 'WhatsNewController@index')->name('new.index');

// settings
Route::get('settings', 'UserController@settings')->name('user.settings');
Route::put('settings/update', 'UserController@update')->name('user.update.store');

// privacy
Route::get('privacy', 'IndexController@privacy');

// about
Route::get('about', 'IndexController@about');
