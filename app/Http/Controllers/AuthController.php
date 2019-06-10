<?php

namespace App\Http\Controllers;

use App\User;
use Socialite;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginForm() 
    {
        return view('login');
    }

    /**
     * Redirect to login facebook api.
     */
    public function login()
    {
        return Socialite::driver('facebook')->scopes(['user_friends'])->redirect();
    }

    /**
     * Get authenticated user from facebook
     */
    public function confirm()
    {
        $fbUser = Socialite::driver('facebook')->user();

        $user = User::where('provider', 'facebook')
            ->where('provider_user_id', $fbUser->id)
            ->first();

        if(!$user) {
            $user = new User();
            $user->provider = 'facebook';
            $user->provider_user_id = $fbUser->id;
            $user->provider_user_token = $fbUser->token;
            $user->name = $fbUser->name;
            $user->pic = $fbUser->avatar;
            $user->uuid = bin2hex(random_bytes(8));
            $user->save();
        }

        auth()->login($user);  

        return redirect('/');    
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $user = auth()->logout();
        return redirect('/');
    }
}
