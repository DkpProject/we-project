<?php

namespace App\Http\Controllers\Ajax;

use App\Mail\BugReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class BugTracker extends Controller
{
    private function get_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip=$_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        else $ip=$_SERVER['REMOTE_ADDR'];
        return $ip;
    }

    public function newMessage(Request $request)
    {
        $args = $request->all();
        if (mb_strlen($args['descr']) > 5) {
            $args['firstname'] = \Auth::user()->firstname;
            $args['surname'] = \Auth::user()->surname;
            $args['id'] = \Auth::user()->id;
            $args['browser'] = $_SERVER["HTTP_USER_AGENT"];
            $args['ip'] = $this->get_ip();

            Mail::to('exsinord@yandex.ru')->queue(new BugReport($args));
            return "ok";
        } else {
            return "error";
        }
    }
}
