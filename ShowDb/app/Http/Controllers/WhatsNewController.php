<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use ShowDb\User;
use ShowDb\Song;
use ShowDb\Show;
use ShowDb\ShowImage;
use ShowDb\ShowNote;
use ShowDb\SetlistItem;
use ShowDb\SetlistItemNote;
use Carbon\Carbon;
use DB;

class WhatsNewController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('username');
    }

    public function index(Request $request) {
        DB::statement('SET GLOBAL group_concat_max_len = 1000000');
        $shows = Show::select(DB::raw(
            'GROUP_CONCAT(CONCAT(\'{"id":"\', id, \'"}\')) as data'), 
            DB::raw('Date(created_at) as create_date'))
            ->whereNull('shows.user_id')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(365))
            ->groupBy(DB::raw('Date(created_at)'))
            ->orderBy('created_at', 'DESC')->get();

        $stuff = [];
        foreach($shows->toArray() as $data) {
            foreach(json_decode('[' . $data['data'] . ']') as $d) {
                $stuff[$data['create_date']]['shows'][] = $d->id;
            }
        }

        $songs = Song::select(DB::raw('GROUP_CONCAT(CONCAT(\'{"id":"\', id, \'"}\')) as data'),
                              DB::raw('Date(created_at) as create_date'))
            ->whereDate('created_at', '>=', Carbon::now()->subDays(365))
            ->groupBy(DB::raw('Date(created_at)'))
            ->orderBy('created_at', 'DESC')->get();

        foreach($songs->toArray() as $data) {
            foreach(json_decode('[' . $data['data'] . ']') as $d) {
                $stuff[$data['create_date']]['songs'][] = $d->id;
            }
        }

        $images = ShowImage::select(DB::raw('GROUP_CONCAT(CONCAT(\'{"id":"\', id, \'"}\')) as data'),
                               DB::raw('Date(created_at) as create_date'))
            ->where('published', '=', '1')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(365))
            ->groupBy(DB::raw('Date(created_at)'))
            ->orderBy('created_at', 'DESC')->get();

        foreach($images->toArray() as $data) {
            foreach(json_decode('[' . $data['data'] . ']') as $d) {
                $stuff[$data['create_date']]['photos'][] = $d->id;
            }
        }

        $notes = ShowNote::select(DB::raw('GROUP_CONCAT(CONCAT(\'{"id":"\', id, \'"}\')) as data'),
                               DB::raw('Date(created_at) as create_date'))
            ->where('published', '=', '1')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(365))
            ->groupBy(DB::raw('Date(created_at)'))
            ->orderBy('created_at', 'DESC')->get();

        foreach($notes->toArray() as $data) {
            foreach(json_decode('[' . $data['data'] . ']') as $d) {
                $stuff[$data['create_date']]['notes'][] = $d->id;
            }
        }

        $users = User::select(DB::raw('GROUP_CONCAT(CONCAT(\'{"id":"\', id, \'"}\')) as data'),
                               DB::raw('Date(created_at) as create_date'))
            ->whereDate('created_at', '>=', Carbon::now()->subDays(365))
            ->groupBy(DB::raw('Date(created_at)'))
            ->orderBy('created_at', 'DESC')->get();

        foreach($users->toArray() as $data) {
            foreach(json_decode('[' . $data['data'] . ']') as $d) {
                $stuff[$data['create_date']]['users'][] = $d->id;
            }
        }

        $videos = SetlistItemNote::select(DB::raw('GROUP_CONCAT(CONCAT(\'{"id":"\', id, \'"}\')) as data'),
                               DB::raw('Date(created_at) as create_date'))
            ->whereDate('created_at', '>=', Carbon::now()->subDays(365))
            ->groupBy(DB::raw('Date(created_at)'))
            ->orderBy('created_at', 'DESC')->get();

        foreach($videos->toArray() as $data) {
            foreach(json_decode('[' . $data['data'] . ']') as $d) {
                $stuff[$data['create_date']]['videos'][] = $d->id;
            }
        }

        ksort($stuff);
        $stuff = array_reverse($stuff, true);

        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
 
        // Create a new Laravel collection from the array data
        $itemCollection = collect($stuff);
 
        // Define how many items we want to be visible in each page
        $perPage = 15;
 
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
 
        // set url path for generted links
        $paginatedItems->setPath($request->url());

        return view('whatsnew.index')
            ->withStuff($paginatedItems)
            ->withUser($request->user())
            ->withOrder('');
    }
}
