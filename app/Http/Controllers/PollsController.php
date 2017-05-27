<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;

use App\Models\CatalogCats;
use App\Models\Poll;
use App\Models\PollsAnswer;
use App\Models\Specialty;

use Illuminate\Http\Request;
use Validator;

class PollsController extends Controller
{
    public function index()
    {
        return view('polls.index');
    }

    public function poll($id)
    {
        $poll = Poll::findOrFail($id);

        if(!Specialty::where('spec_id', $poll->category_id)
            ->where('user_id', \Auth::user()->id)
            ->count())
            return Notify::create('Вам не доступен этот опрос, так как относится к категории не вашей специализации', 'danger', redirect('/polls'));

        if(PollsAnswer::where('user_id', \Auth::user()->id)
            ->where('poll_id', $poll->id)
            ->count())
            return Notify::create('Вы уже проходили этот опрос', 'danger', redirect('/polls'));

        return view('polls.poll', ['poll' => $poll]);
    }

    public function answer($id, Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $poll = Poll::findOrFail($id);
        if(!Specialty::where('spec_id', $poll->category_id)
            ->where('user_id', \Auth::user()->id)
            ->count())
            return Notify::create('Вам не доступен этот опрос, так как относится к категории не вашей специализации', 'danger', redirect('/polls'));
        if(PollsAnswer::where('user_id', \Auth::user()->id)
            ->where('poll_id', $poll->id)
            ->count())
            return Notify::create('Вы уже проходили этот опрос', 'danger', redirect('/polls'));

        $valid = [];
        foreach ($poll->questions as $item)
            $valid['question-'.$item->id] = "required";

        Validator::make($data, $valid)->validate();
        foreach ($data as $key => $value) {
            $qid = explode("-", $key);
            PollsAnswer::create([
                'user_id' => \Auth::user()->id,
                'question_id' => $qid[1],
                'poll_id' => $id,
                'answer' => $value,
            ]);
        }

        return Notify::create('Спасибо, что прошли наш опрос, нам очень важно ваше мнение!', 'success', redirect('/polls'));
    }
}
