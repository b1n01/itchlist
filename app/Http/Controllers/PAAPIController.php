<?php

namespace App\Http\Controllers;

use App\Itch;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Handles Amazon PA API until they approve Itchlist
 */
class PAAPIController extends Controller
{
    /**
     * Get the form to update Itches
     */
    public function form()
    {
        if(auth()->user()->name != 'Luca Lorenzini') {
            return view('list');
        }
    
        $itches = Itch::where('pic', '')->get();

        if(!$itches) {
            return 'All done';
        }

        return view('_paapi', ['itches' => $itches]);
    }

    /**
     * Update an Itch
     * @param Itch's id
     */
    public function update(Request $request, $id)
    {
        if(auth()->user()->name != 'Luca Lorenzini') {
            return view('list');
        }

        $url = $request->input('url');
        $pic = $request->input('pic');
        $description = $request->input('description');
        $price = $request->input('price');

        if(!$url || !$pic || !$description || !$price) {
            return 'Invalid parameters';
        }

        $itch = Itch::find($id);
        if(!$itch) {
            return 'Itch not found';
        }

        $itch->url = $url;
        $itch->pic = $pic;
        $itch->description = $description;
        $itch->price = $price;

        $itch->save();
        
        return 'Ok';
    }
}