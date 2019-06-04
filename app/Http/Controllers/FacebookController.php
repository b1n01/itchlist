<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
    public function friends()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => env('FACEBOOK_CLIENT_ID'),
            'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
            'default_graph_version' => 'v3.3',
        ]);

        $user = auth()->user();

        try {
            $friendsResponse = $fb->get(
                "/me/friends?fields=name,picture",
                $user->provider_user_token
            );
        } catch(FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $friendsGraphEdge = $friendsResponse->getGraphEdge();

        $friends = [];
        foreach ($friendsGraphEdge as $friendsGraphNode) {

            $localUser = User::where('provider_user_id', $friendsGraphNode->getField('id'))->first();

            $friends[] = [
                'name' => $friendsGraphNode->getField('name'),
                'pic' => $friendsGraphNode->getProperty('picture')->getField('url'),
                'uuid' => $localUser->uuid,
            ];
        }

        return response()->json($friends);
    }
}
