<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Service;

class Search extends Controller
{
    public function full_search(Request $request) {
        $query = $request->all();
        $query['query'] = str_replace(' ', '%', urldecode($query['query']));
        $catalog = Catalog::where('name', 'LIKE', '%'.$query['query'].'%')->where('visible', true)->where('disabled', false)->take(5)->get();
        $service = Service::where('name', 'LIKE', '%'.$query['query'].'%')->where('visible', true)->where('disabled', false)->take(5)->get();
        return view('search.ajax', ['query' => $query['query'], 'catalog' => $catalog, 'service' => $service]);
    }
}
