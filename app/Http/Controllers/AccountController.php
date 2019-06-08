<?php

namespace App\Http\Controllers;

use App\User;

class AccountController extends Controller
{
    public function account()
    {
        $user = auth()->user();
        return view('account', ['user' => $user]);           
    }

    public function delete()
    {
        $user = auth()->user();
        $user->delete();
        
        return response()->json(['response' => 'ok']);
    }
}
