<?php

namespace App\Http\Controllers;

use App\Itch;
use App\Services\Friendship;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Goutte\Client as Guotte;

/**
 * Handles Itches actions
 */
class ItchController extends Controller
{
    /**
     * Add an Itch
     * @param Request $request
     */
    public function add(Request $request)
    {
        $url = trim($request->get('provider-url'));

        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            return response()->json(['response' => 'Invalid url'], 400);
        }

        if (strpos( parse_url($url)['host'], 'amazon') == false ) {
            return response()->json(['response' => 'Invalid url'], 400);
        }

        // TODO use amazon productio api
        
        $guotte = new Guotte();
        $crawler = $guotte->request('GET', $url);

        $description = '';
        $crawler->filter('#productTitle')->each(function($node) use (&$description){
            $description = substr(trim($node->text()), 0, 250);
        });

        $price = '';
        $crawler->filter('#priceblock_dealprice')->each(function($node) use (&$price){
            $price = substr(trim($node->text()), 0, 20);
        });

        $seller = '';
        $crawler->filter('#bylineInfo')->each(function($node) use (&$seller){
            $seller = substr(trim($node->text()), 0, 75);
        });

        $pic = '';
        $crawler->filter('#landingImage')->each(function($node) use (&$pic){
            $pic = trim($node->text());
        });

        $itch = new Itch();
        $itch->user_id = auth()->user()->id;
        $itch->url = $url;
        $itch->pic = $pic;
        $itch->price = $price;
        $itch->seller = $seller;
        $itch->description = $description;
        $itch->provider = 'amazon';
        $itch->booked_by = null;

        $itch->save();

        return response()->json(['response' => 'ok']);
    }

    /**
     * Delete an Itch
     * @param  integer $id Itch's id
     */
    public function delete($id)
    {
        $itch = Itch::find($id);
        $user = auth()->user();

        if($itch && $itch->user_id == $user->id) {
            $itch->delete();
        }

        return response()->json(['response' => 'ok']);
    }

    /**
     * Book an Itch for a friend
     * @param  integer $id Itch's id
     */
    public function book($id, Friendship $friendship)
    {
        $user = auth()->user();

        $itch = Itch::find($id);
        if(!$itch) {
            return response()->json(['response' => 'Itch not found'], 404);
        } 

        if($itch->booked_by) {
            return response()->json(['response' => 'Itch already booked'], 401);                
        }

        if($itch->user_id == $user->id) {
            return response()->json(['response' => 'You cannot book your Itches'], 401);
        }

        $friend = User::find($itch->user_id);
        $areFriend = $friendship->areFriends($user, $friend);
        if(!$areFriend) {
            return response()->json(['response' => 'You can only book for your friends'], 401);
        }

        $itch->booked_by = $user;
        $itch->save();

        return response()->json(['response' => 'ok']);
    }

    /**
     * Toggle Itches visibility
     * @param  integer $id Itch's id
     */
    public function toggle($id)
    {
        $itch = Itch::find($id);
        if(!$itch) {
            return response()->json(['response' => 'Itch not found'], 404);
        } 
       
        $user = auth()->user();
        if($itch->user_id != $user->id) {
            return response()->json(['response' => 'You can only toggle your Itches'], 401);
        }

        $itch->hidden = !$itch->hidden;
        $itch->save();

        return response()->json(['response' => 'ok']);
    }
}
