<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Deals extends Controller
{
    function goods(Request $request) {
        $list = [];
        foreach($request->user()->activeDeals()->where('item_type', 'App\Models\Catalog')->get() as $deal) {
            if ($deal->seller->id == $request->user()->id) $participant = $deal->purchaser;
            else $participant = $deal->seller;

            $list[] = array(
                'id' => $deal->id,
                'item' => array(
                    'id' => $deal->item->id,
                    'name' => $deal->item->name
                ),
                'participant' => array(
                    'id' => $participant->id,
                    'fullname' => $participant->firstname . ' ' . $participant->surname,
                ),
                'cost' => $deal->cost
            );
        }
        return $list;
    }
}
