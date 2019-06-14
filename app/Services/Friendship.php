<?php

namespace App\Services;
 
use App\User;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;

/**
 * Handles the 'Facebook friends' logic  
 */
class Friendship
{
    /** @var Facebook */
    private $facebook;

    /**
     * Inint facebook sdk
     */
    public function __construct()
    {
        $this->facebook = new \Facebook\Facebook([
            'app_id' => config('services.facebook.client_id'),
            'app_secret' => config('services.facebook.client_secret'),
            'default_graph_version' => 'v3.3',
        ]);
    }

    /**
     * Get a list of friends for a User
     * @param User $user
     * @return array
     */
    public function getFriends(User $user)
    {
      try {
            $friendsResponse = $this->facebook->get(
                "/me/friends?fields=name,picture",
                $user->provider_user_token
            );
        } catch(FacebookResponseException $e) {
            return $this->handleException($e);
        }

        $friendsGraphEdge = $friendsResponse->getGraphEdge();

        $friends = [];
        foreach ($friendsGraphEdge as $friendsGraphNode) {

            $localUser = User::where('provider_user_id', $friendsGraphNode->getField('id'))->first();

            if($localUser) {
                $friends[] = [
                    'name' => $friendsGraphNode->getField('name'),
                    'pic' => $friendsGraphNode->getProperty('picture')->getField('url'),
                    'uuid' => $localUser->uuid,
                ];
            }
        }

        return $friends;
    }

    /**
     * Check if two user are Facebook friends
     * @param  User     $user
     * @param  User     $friend
     * @return boolean
     */
    public function areFriends($user, $friend)
    {
        $areFriends = false;

        try {
            $friendsResponse = $this->facebook->get(
                "/me/friends/".$friend->provider_user_id,
                $user->provider_user_token
            );
        } catch(FacebookResponseException $e) {
            return $this->handleException($e);
        }

        $friendsGraphEdge = $friendsResponse->getGraphEdge();

        foreach ($friendsGraphEdge as $friendsGraphNode) {
            $areFriends = true; // TODO better way to do this?
        }

        return $areFriends;
    }

    /**
     * @see https://developers.facebook.com/docs/facebook-login/access-tokens/debugging-and-error-handling
     */
    private function handleException($e)
    {
        switch ($e->getCode()) {
            case 190:
                $body = ['message' => 'Facebook Unauthorized', 'action' => route('login.form')];
                $code = 401;
                break;
            default:
                $body = ['message' => 'Error contactin Facebook'];
                $code = 500;
                break;
        }

        return response()->json($body, $code);
    }
}