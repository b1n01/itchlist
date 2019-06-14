<?php

namespace App\Http\Controllers;

use App\Itch;
use App\User;
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
    public function friendList($uuid)
    {
        // If no user found from uii -> erroe
        $otherUser = User::where('uuid', $uuid)->first();
        if(!$friend) {
            return redirect('/');
        }
        
        $itches = Itch::where('user_id', $otherUser->id)->orderBy('created_at', 'desc')->get();
        $user = auth()->user();

        // If the user is not logged in
        $user = auth()->user();
        $areFriends = false;
        if($user) {
            $areFriends = $this->areFriends($user, $otherUser);
        }

        $itches = Itch::where('user_id', $otherUser->id)->orderBy('created_at', 'desc')->get();
        
        return view('list', ['user' => $otherUser, 'itches' => $itches, 'areFriends' => $areFriends]);
    }

    /**
     * Check if two user are Facebook friends
     * @param  [type] $user   [description]
     * @param  [type] $friend [description]
     * @return boolean
     */
    public static function areFriends($user, $friend)
    {
        // TODO this should be in a service

        $areFriends = false;

        // Check if uuid user is friend with the logged user
        $fb = new \Facebook\Facebook([
            'app_id' => config('services.facebook.client_id'),
            'app_secret' => config('services.facebook.client_secret'),
            'default_graph_version' => 'v3.3',
        ]);

        try {
            $friendsResponse = $fb->get(
                "/me/friends/".$friend->provider_user_id,
                $user->provider_user_token
            );
        } catch(FacebookResponseException $e) {
            return FacebookController::handleFacebookException($e);
        }

        $friendsGraphEdge = $friendsResponse->getGraphEdge();

        foreach ($friendsGraphEdge as $friendsGraphNode) {
            $areFriends = true; // TODO better way to do this?
        }

        return $areFriends;
    }
}
