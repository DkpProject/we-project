<?php

namespace App\Http\Controllers\Api;

use App\Models\Catalog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Goods extends Controller
{
    function mygoods(Request $request) {
        $list = [];
        foreach($request->user()->catalog()->get() as $good) {
            $list[] = array(
                'id' => $good->id,
                'name' => $good->name,
                'category' => $good->cat->name,
                'used' => $good->used,
                'price' => $good->cost,
                'dealType' => $good->deal_type,
                'evaluation' => $good->evaluation,
                'date' => $good->created_at->toDateTimeString(),
                'preview' => '/images/uploads/catalog/'.$good->images()->first()->file
            );
        }
        return $list;
    }

    function good(Request $request, $id) {
        $good = Catalog::findOrFail($id);
        $images = [];
        foreach ($good->images as $image) {
            $images[] = '/images/uploads/catalog/'.$image->file;
        }
        $good['image'] = $images;
        $good['category'] = $good->cat->name;
        $good['owner'] = array(
            'id' => $good->user->id,
            'firstname' => $good->user->firstname,
            'surname' => $good->user->surname,
            'avatar' => '/images/uploads/user/'.$good->user->images()->first()->file,
            'rate' => 3.5,
            'created_at' => $good->user->created_at->toDateTimeString()
        );
        return $good;
    }
}
