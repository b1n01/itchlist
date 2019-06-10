<?php

namespace App\Http\Controllers;

use App\Itch;
use App\User;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function list()
    {
        $user = auth()->user();
        if($user) {
            $itches = Itch::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            return view('home', ['itches' => $itches]);           
        } else {
            $itches = Itch::orderBy('created_at', 'desc')->limit(15)->get();
            return view('home', ['itches' => $itches]);
        }
    }

    public function friendList($uuid)
    {
        // If no user found from uii -> erroe
        $friend = User::where('uuid', $uuid)->first();
        if(!$friend) {
            return redirect('/');
        }
        
        $itches = Itch::where('user_id', $friend->id)->orderBy('created_at', 'desc')->get();
        $user = auth()->user();

        // If the user is not logged in
        $user = auth()->user();
        $areFriends = false;
        if($user) {
            $areFriends = $this->areFriends($user, $friend);
        }

        $itches = Itch::where('user_id', $friend->id)->orderBy('created_at', 'desc')->get();
        return view('list', ['user' => $friend, 'itches' => $itches, 'areFriends' => $areFriends]);
    }

    public static function areFriends($user, $friend)
    {
        $areFriends = false;

        // Check is uuid user is friend with the logged user
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
