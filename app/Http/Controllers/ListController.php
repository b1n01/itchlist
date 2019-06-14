<?php

namespace App\Http\Controllers;

use App\Itch;
use App\User;
use App\Services\Friendship;
use Illuminate\Http\Request;

/**
 * Handles Itch lists
 */
class ListController extends Controller
{
    /**
     * Get itches list (your list if the user is logged, 'recently added' if guest)
     */
    public function list()
    {
        $user = auth()->user();
        if($user) {
            $itches = Itch::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        } else {
            $itches = Itch::orderBy('created_at', 'desc')->limit(15)->get();
        }

        return view('home', ['itches' => $itches]);                   
    }

    /**
     * Get a user list
     * @param  integer $uuid The user uuid
     */
    public function friendList($uuid, Friendship $friendship)
    {
        // If no user found from uii -> error
        $otherUser = User::where('uuid', $uuid)->first();
        if(!$otherUser) {
            return redirect(route('list'));
        }
        
        $itches = Itch::where('user_id', $otherUser->id)->orderBy('created_at', 'desc')->get();
        $user = auth()->user();

        // If the user is not logged in
        $user = auth()->user();
        $areFriends = false;
        if($user) {
            $areFriends = $friendship->areFriends($user, $otherUser);
        }

        $itches = Itch::where('user_id', $otherUser->id)->orderBy('created_at', 'desc')->get();

        return view('list', ['user' => $otherUser, 'itches' => $itches, 'areFriends' => $areFriends]);
    }
}
