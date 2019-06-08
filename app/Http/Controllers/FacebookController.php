<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
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
        } catch(FacebookExceptionsFacebookResponseException $e) {
            return response()->json(['message' => 'erroe contactin Facebook'], 500);
        } catch(FacebookExceptionsFacebookSDKException $e) {
            return response()->json(['message' => 'erroe contactin Facebook'], 500);
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
}
