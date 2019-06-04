<?php

namespace App\Http\Controllers;

use App\Itch;
use Illuminate\Http\Request;
use Goutte\Client as Guotte;


class ItchController extends Controller
{
    public function add(Request $request)
    {
        $url = $request->get('provider-url');
        
        $guotte = new Guotte();
        $crawler = $guotte->request('GET', $url);

        $description = null;
        $crawler->filter('#productTitle')->each(function($node) use (&$description){
            $description = trim($node->text());
        });

        $price = '';
        $crawler->filter('#priceblock_dealprice')->each(function($node) use (&$price){
            $price = trim($node->text()) ? trim($node->text()) : $price;
        });

        $seller = null;
        $crawler->filter('#bylineInfo')->each(function($node) use (&$seller){
            $seller = trim($node->text());
        });

        $itch = new Itch();
        $itch->user_id = auth()->user()->id;
        $itch->url = $url;
        $itch->pic = ''; // TODO PIC
        $itch->price = $price;
        $itch->seller = $seller;
        $itch->description = $description;
        $itch->provider = 'amazon';

        $itch->save();

        return response()->json(['response' => 'ok']);
    }

    public function delete($id)
    {
        $itch = Itch::find($id);

        if($itch && $itch->user_id == auth()->user()->id) {
            //$itch->delete();
        }

        return response()->json(['response' => 'ok']);
    }

    public function book($id)
    {
        $itch = Itch::find($id);

        if(!$itch) {
            return Response::json(['response' => 'Itch not found'], 404);
        } else {
            $user = auth()->user();
            $friend = User::find($itch->user_id);
            $areFriend = ListController::areFriends($user, $friend);
            if(!$areFriend) {
                return Response::json(['response' => 'You can only book for your frineds'], 401);
            }

            $itch->booked_by = $user;
            $itch->save();
        }

        return response()->json(['response' => 'ok']);
    }

    public function hide($id) {
       return response()->json(['response' => 'To be implemented']);
    }
}
