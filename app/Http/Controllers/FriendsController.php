<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Services\Friendship;

/**
 * Handles facebook friends
 */
class FriendsController extends Controller
{
    /**
     * Get list of friends from facebook
     */
    public function friends(Friendship $friendship)
    {
        $user = auth()->user();
        $friends = $friendship->getFriends($user);

        return response()->json($friends);
    }
}