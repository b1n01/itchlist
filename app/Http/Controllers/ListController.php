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
            $itches = Itch::where('hidden', false)->orderBy('created_at', 'desc')->limit(30)->get();
        }

        return view('home', ['itches' => $itches]);                   
    }

    /**
     * Get a user list
     * @param  integer $uuid The user uuid
     */
    public function userList($uuid, Friendship $friendship)
    {
        // If no user found from uii -> error
        $otherUser = User::where('uuid', $uuid)->first();
        if(!$otherUser) {
            return redirect(route('list'));
        }
        
        // If the user is not logged in
        $user = auth()->user();
        $areFriends = false;
        if($user) {
            $areFriends = $friendship->areFriends($user, $otherUser);
        }

        $itches = Itch::where('user_id', $otherUser->id)
            ->where('hidden', false)
            ->orderBy('created_at', 'desc')
            ->with('bookedBy')
            ->get();

        return view('list', ['user' => $otherUser, 'itches' => $itches, 'areFriends' => $areFriends]);
    }

    /**
     * Get list of booked itches
     */
    public function booked()
    {
        $user = auth()->user();
        $itches = Itch::where('booked_by', $user->id)
            ->with('user')
            ->where('hidden', false)
            ->orderBy('created_at', 'desc')->get();

        return view('booked', ['itches' => $itches]);
    }

    /**
     * Get a list of itches add by your friends
     */
    public function feed(Friendship $friendship)
    {
        $user = auth()->user();
        $friends = $friendship->getFriends($user);

        $uuids = array_map(function($friend) {
            return $friend['uuid'];
        }, $friends);

        $itches = Itch::where('hidden', false)
            ->with('user')
            ->whereHas('user', function($query) use ($uuids) {
                $query->whereIn('uuid', $uuids);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('feed', ['itches' => $itches]);
    }
}
