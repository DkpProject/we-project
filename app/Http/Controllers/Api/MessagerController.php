<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagerController extends Controller
{
    function dialogs(Request $request) {
        $user = $request->user();
        $from = Message::where('from', $user->id)
            ->where('to', '<>', $user->id)
            ->where('type', 0)
            ->orderBy('id', 'desc')
            ->groupBy('to');

        $to = Message::where('to', $user->id)
            ->whereNotIn('from', $from
                ->pluck('to')
                ->toArray()
            )
            ->orderBy('id', 'desc')
            ->groupBy('from')
            ->union($from)
            ->get();

        $list = [];
        foreach ($to as $dialog) {
            if ($dialog->author->id == $user->id) $interlocutor = $dialog->recipient;
            else $interlocutor = $dialog->author;

            $lastMessage = Message::lastMessage($user->id, $interlocutor->id);
            $list[$interlocutor->id] = array(
                'user' => $interlocutor->firstname . ' ' . $interlocutor->surname,
                'avatar' => '/images/uploads/user/'.$interlocutor->images()->first()->file,
                'messages' => [
                    array(
                        'date' => $lastMessage->created_at->format('H:i'),
                        'from' => $lastMessage->from,
                        'content' => $lastMessage->text,
                        'read' => $lastMessage->read
                    )
                ]
            );
        }
        return $list;
    }

    function messages(Request $request, $id) {
        $messages = array();
        foreach(Message::allMessages($request->user()->id, $id) as $message) {
            $messages[] = array(
                'date' => $message->created_at->format('H:i'),
                'read' => $message->read,
                'from' => $message->from,
                'content' => $message->text
            );
        }
        return $messages;
    }
}
