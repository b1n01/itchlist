<?php

namespace App\Http\Controllers;

use App\User;
use Socialite;
use Illuminate\Http\Request;

/**
 * Handles user authentication
 */
class AuthController extends Controller
{
    /**
     * Render login form
     */
    public function loginForm() 
    {
        return view('login');
    }

    /**
     * Redirect to facebook login
     */
    public function login()
    {
        return Socialite::driver('facebook')
            ->with(['auth_type' => 'rerequest']) // reask for permission if removed
            ->scopes(['user_friends']) // ask for 'friends list' permissin
            ->redirect();
    }

    /**
     * Get authenticated user from facebook
     */
    public function confirm()
    {
        $fbUser = Socialite::driver('facebook')->user();

        // TODO what if the user did not accept facebook login?
        
        $user = User::where('provider', 'facebook')
            ->where('provider_user_id', $fbUser->id)
            ->first();

        if(!$user) {
            $user = new User();
            $user->provider = 'facebook';
            $user->provider_user_id = $fbUser->id;
            $user->name = $fbUser->name;
            $user->pic = $fbUser->avatar;
            $user->uuid = bin2hex(random_bytes(8));
        }

        $user->provider_user_token = $fbUser->token;
        $user->save();

        auth()->login($user);

        return redirect(route('list'));
    }

    /**
     * Logout user
     */
    public function logout()
    {
        // TODO also logout from facebook?
        
        $user = auth()->logout();

        return redirect(route('list'));
    }
}
