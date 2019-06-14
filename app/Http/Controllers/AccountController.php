<?php

namespace App\Http\Controllers;

use App\User;

/**
 * Handles the user's account section
 */
class AccountController extends Controller
{
    /**
     * Render the account views
     */
    public function account()
    {
        $user = auth()->user();
        
        return view('account', ['user' => $user]);           
    }

    /**
     * Logout and delete user account
     */
    public function delete()
    {
        // TODO also logout from facebook?
        
        $user = auth()->user();
        $user->logout();
        $user->delete();
        
        return response()->json(['response' => 'ok']);
    }
}
