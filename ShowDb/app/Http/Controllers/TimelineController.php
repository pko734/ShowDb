<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use ShowDb\TimelineSlide;
use ShowDb\Album;


class TimelineController extends Controller
{
    public function index(Request $request) {
        $ts = TimelineSlide::where('type', '=', 'title')->first();

        $ta = ['title' => [], 'events' => []];
        if($ts->text_headline) {
            $ta['title']['text']['headline'] = $ts->text_headline;
        }
        if($ts->text_text) {
            $ta['title']['text']['text'] = $ts->text_text;
        }
        if($ts->media_url) {
            $ta['title']['media']['url'] = $ts->media_url;
        }
        if($ts->media_caption) {
            $ta['title']['media']['caption'] = $ts->media_caption;
        }
        if($ts->media_credit) {
            $ta['title']['media']['credit'] = $ts->media_credit;
        }
        if($ts->media_thumbnail_url) {
            $ta['title']['media']['thumbnail_url'] = $ts->media_thumbnail_url;
        }
        if($ts->media_link) {
            $ta['title']['media']['link'] = $ts->media_link;
        }
        if($ts->media_link_target) {
            $ta['title']['media']['link_target'] = $ts->link_target;
        }

        $ev = TimelineSlide::where('type', '!=', 'title')->get();
        foreach($ev as $e) {
            $event = [];
            if($e->start_date) {
                $stamp = strtotime($e->start_date);
                $event['start_date']['month'] = date("m", $stamp);
                $event['start_date']['day'] = date("d", $stamp);
                $event['start_date']['year'] = date("Y", $stamp);
            }
            if($e->end_date) {
                $stamp = strtotime($e->end_date);
                $event['end_date']['month'] = date("m", $stamp);
                $event['end_date']['day'] = date("d", $stamp);
                $event['end_date']['year'] = date("Y", $stamp);
            }
            #$event['background'] = ['color' => '#000000'];
            if($e->start_time) {
                $event['start_time']['headline'] = $e->text_headline;
            }
            if($e->end_time) {
                $event['end_time']['headline'] = $e->text_headline;
            }
            if($e->text_headline) {
                $event['text']['headline'] = $e->text_headline;
            }
            if($e->text_text) {
                $event['text']['text'] = $e->text_text;
            }
            if($e->media_url) {
                $event['media']['url'] = $e->media_url;
            }
            if($e->media_caption) {
                $event['media']['caption'] = $e->media_caption;
            }
            if($e->media_credit) {
                $event['media']['credit'] = $e->media_credit;
            }
            if($e->media_thumbnail_url) {
                $event['media']['thumbnail_url'] = $e->media_thumbnail_url;
            }
            if($e->background) {
                $event['background'] = ['url' => $e->background];
            }
            if($e->media_link) {
                $event['media']['link'] = $e->media_link;
            }
            if($e->media_link_target) {
                $event['media']['link_target'] = $e->link_target;
            }
            if($e->display_date) {
                $event['display_date'] = $e->display_date;
            }
            $ta['events'][] = $event;
        }

        $album_events = $this->_getAlbumEvents();

        $ta['events'] = array_merge($ta['events'], $album_events);
        $timeline = $ta;

        return view('timeline.index')
            ->withUser($request->user())
            ->withTimeline($timeline);
    }

    private function _getAlbumEvents() {
        $albums = Album::whereYear('release_date', '<', 5000)
            ->orderBy('release_date', 'asc')
            ->get();

        $events = [];
        foreach($albums as $album) {
            $stamp = strtotime($album->release_date);
            $event = [];
            $event['start_date']['month'] = date("m", $stamp);
            $event['start_date']['day'] = date("d", $stamp);
            $event['start_date']['year'] = date("Y", $stamp);
            $event['text']['headline'] = $album->title;
            $event['text']['text'] = '';
            $event['text']['text'] .= $this->_getAlbumSongs($album);
            if($album->spotify_link) {
                $event['text']['text'] .= $album->spotify_link;
            }
            if($album->description) {
                $event['text']['text'] .= '<hr>' . $album->description;
            }
            $event['media']['url'] = '/images/albumcovers/' . $album->id . '.jpg';
            $event['media']['caption'] = "<a href=\"/albums/{$album->id}\">View this album in the database</a>";
            $event['group'] = 'album release';
            $events[] = $event;
        }
        return $events;
    }

    private function _getAlbumSongs($album) {
        $songs = '<ol>';
        foreach($album->albumItems->sortBy('order') as $item) {
            $songs .= "<li><a href=\"/songs/{$item->song->id}\"> {$item->song->title}</a></li>";
        }
        $songs .= '</ol>';
        return $songs;
    }
}
