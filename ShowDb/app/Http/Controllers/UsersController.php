<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use ShowDb\User;

class UsersController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('username');
    }

    public function index(Request $request) {
        $this->validate($request, [
                                   'o' => 'in:username-asc,username-desc,shows_count-asc,shows_count-desc',
                                   'q' => 'string|min:3'
                                   ]);

        $q = $request->get('q');

        $o = $request->get('o') ?: 'shows_count-desc';
        $sort_order = explode('-', $o);

        $users = User::where('share', '=', '1')
            ->whereNotNull('username')
            ->withCount('shows');
        
        if($q) {
            $users = $users->where('username', 'LIKE', "%{$q}%");
        }

        $users = $users->orderBy($sort_order[0], $sort_order[1])
            ->paginate(20)
            ->setPath('')
            ->appends( [
                        'q' => $request->get('q'),
                        'o' => $request->get('o'),
                        ]);

        $user_order = 'username-asc';
        if( $o === $user_order ) {
            $user_order = 'username-desc';
        }

        $show_order = 'shows_count-asc';
        if( $o === $show_order ) {
            $show_order = 'shows_count-desc';
        }

        return view('users.index')
            ->withUser($request->user())
            ->withUsers($users)
            ->withUserOrder($user_order)
            ->withShowOrder($show_order);
    }
}
