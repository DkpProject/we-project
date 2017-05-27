<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Message;
use App\Models\Deal;
use App\Models\DealsMessages;

use App\Helpers\DealHelper;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class Chat extends Controller
{
    public function dealSend(Request $request, $id) {
        $data = $request->all();
        $deal = Deal::findOrFail($id);
        if (policy(Deal::class)->view(\Auth::user(), $deal)) {
            DealHelper::message($deal, $data['comment'], \Auth::user());
        }
        return $this->dealReload($id);
    }

    public function dealReload($id) {
        $deal = Deal::findOrFail($id);
        return view('deal.chat', ['deal' => $deal]);
    }

    public function dialogSend($id, Request $request) {
        if ($id == \Auth::user()->id)
            return redirect('/chat');

        $data = $request->all();
        Validator::make($data, [
            'text' => 'required|min:1',
        ])->validate();
        Message::create([
            'from' => \Auth::user()->id,
            'to' => $id,
            'text' => $data['text'],
            'read' => 0,
        ]);
        return $this->dialogReload($id);
    }

    public function dialogReload($id) {
        if ($id == \Auth::user()->id)
            return redirect('/chat');
        Message::where('to', \Auth::user()->id)->where('from', $id)->update(['read' => 1]);
        $messages = Message::allMessages(\Auth::user()->id, $id);
        return view('messages.chat', ['messages' => $messages]);
    }
}
