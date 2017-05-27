<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index() {
        $from = Message::where('from', \Auth::user()->id)
            ->where('to', '<>', \Auth::user()->id)
            ->where('type', 0)
            ->orderBy('id', 'desc')
            ->groupBy('to');

        $to = Message::where('to', \Auth::user()->id)
            ->whereNotIn('from', $from
                ->pluck('to')
                ->toArray()
            )
            ->orderBy('id', 'desc')
            ->groupBy('from')
            ->union($from)
            ->get();
        return view('messages.index', ['dialogs' => $to]);
    }

    public function dialog($id) {
        $user = User::findOrFail($id);
        if ($id == \Auth::user()->id)
            return redirect('/chat');
        Message::where('to', \Auth::user()->id)
            ->where('from', $id)
            ->update(['read' => 1]);
        $messages = Message::allMessages(\Auth::user()->id, $id);
        return view('messages.dialog', ['messages' => $messages, 'user' => $user]);
    }
}
