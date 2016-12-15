# xkcd Password Generator

## Live URL
<http://p4.pauloehler.com>
or
<http://db.nov.blue>

## Description
A maintainable database of Shows, Songs, Setlists, Notes, and Videos related to the band The Avett Brothers.
They're pretty great, you should check them out.

## Demo
<TODO>

## Details for teaching team

** Logging in **
Two users are seeded as per the requirements.
Jill is a "normal" user.
Jamal is an "admin" user.

You can also login with the "Login With Facebook" link in the top menu.

** CRUD Elements **

1. Songs
Administrators can create, read, update, and delete Songs
Users and Guests can read Songs.

2. Shows
Administers can create, read, update, and delete Shows
Users and Guests can read Shows.

3. Setlist Items (accessible via the "read" component of a Show object)
Setlist Items are basically mappings between a show and the songs played at that show.
Administrators can create, read, update, and delete Setlist Items.
Users and Guests can read Setlist Items.

4. Song Notes
Administrators can create, read, approve (limited edit), or delete Song Notes.
Users can create Song Notes, and can delete Song Notes they've added.
Guests can read Song Notes (once they are approved by an Administrator).

5. Show Notes
Administrators can create, read, approve (limited edit), or delete Show Notes.
Users can create Show Notes, and can delete Show Notes they've added.
Guests can read Show Notes (once they are approved by an Administrator).

6. Video Links (aka Setlist Item Notes)
Administrators can create, read, approve (limited edit), or delete Video Links.
Users and Guests can read Video Links

** Other Elements **

1. Admin vs User vs Guest


## External data source
The data for Songs, Shows, and SetlistItems was gleaned from this site: http://www.asmylifeturnstoasong.com/


## Outside code
* Simple wysiwyg editor for adding Notes : https://alex-d.github.io/Trumbowyg/
* Bootstrap: http://getbootstrap.com/
* jQuery: https://jquery.com/
* Facebook login integration: https://github.com/laravel/socialite
* Laravel debugbar: https://github.com/barryvdh/laravel-debugbar
* Laravel-Auditing: https://github.com/owen-it/laravel-auditing
* Inverse seed generator: https://github.com/orangehill/iseed
* Laravel Driver for the Database Backup Manager: https://github.com/backup-manager/laravel
* Flysystem Adapter for Dropbox: https://github.com/thephpleague/flysystem-dropbox
* Typeahead.js: https://twitter.github.io/typeahead.js/
* bootbox.js: http://bootboxjs.com/
* FontAwesome: http://fontawesome.io/
