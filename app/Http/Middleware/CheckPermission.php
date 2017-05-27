<?php

namespace App\Http\Middleware;

use App\Helpers\Notify;
use Closure;

class CheckPermission
{
    public function handle($request, Closure $next, $role)
    {
        //dd($request->user()->groupPermission()['middleware'][$role]);
        if(array_key_exists($role, $request->user()->groupPermission()->permission['middleware']))
            return Notify::forbiden(redirect($request->user()->groupPermission()->permission['middleware'][$role]));
        return $next($request);
    }
}
