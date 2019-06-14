<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Exceptions\FacebookResponseException;

/**
 * Handles facebook friends
 */
class FriendsController extends Controller
{
    /**
     * Get list of friends from facebook
     */
    public function friends()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => config('services.facebook.client_id'),
            'app_secret' => config('services.facebook.client_secret'),
            'default_graph_version' => 'v3.3',
        ]);

        $user = auth()->user();

        try {
            $friendsResponse = $fb->get(
                "/me/friends?fields=name,picture",
                $user->provider_user_token
            );
        } catch(FacebookResponseException $e) {
            return self::handleFacebookException($e);
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

        return response()->json($friends);
    }

    /**
     * @see https://developers.facebook.com/docs/facebook-login/access-tokens/debugging-and-error-handling
     */
    public static function handleFacebookException($e)
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
