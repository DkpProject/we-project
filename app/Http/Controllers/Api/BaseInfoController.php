<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseInfoController extends Controller
{
    function user(Request $request) {
        $response = $request->user();
        $response['avatar'] = '/images/uploads/user/'.$request->user()->images()->first()->file;
        $response['birthday_format'] = $request->user()->birthday->format('d / m / Y');
        $response['aBalance'] = $request->user()->activeBalance();
        $response['pBalance'] = $request->user()->passiveBalance();
        $response['specialties'] = $request->user()->specs->keyBy('id')->all();
        $response['district'] = District::where('id', $request->user()->district)->first();
        $response['notifications'] = [];

        return $response;
    }

    function specialties() {
        $specs = Category::get();
        $list = [];
        foreach($specs->where('parent_id', 0) as $group) {
            $sublist = [];
            foreach($specs->where('parent_id', $group->id) as $sub) {
                $sublist[] = array("value" => $sub->id, "label" => $sub->name);
            }
            $list[] = array("label" => $group->name, "options" => $sublist);
        }
        return $list;
    }

    function districts() {
        $specs = District::get();
        $list = [];
        foreach($specs->where('parent_id', 0) as $group) {
            $sublist = [];
            foreach($specs->where('parent_id', $group->id) as $sub) {
                $sublist[] = array("value" => $sub->id, "label" => $sub->name);
            }
            $list[] = array("label" => $group->name, "options" => $sublist);
        }
        return $list;
    }

    function myTeam(Request $request) {
        $user = $request->user();
        $invited_by = $user->invited_by->user;
        $list[] = array(
            'id' => $invited_by->id,
            'firstname' => $invited_by->firstname,
            'surname' => $invited_by->surname,
            'confirmed' => $invited_by->confirmed,
            'created_at' => $invited_by->created_at->toDateTimeString(),
            'avatar' => '/images/uploads/user/'.$invited_by->images()->first()->file,
        );
        foreach($user->invited_users as $invited_user) {
            $confirmation = [];
            foreach($invited_user->invited_users()->where('confirmed', false)->get() as $invited) {
                $confirmation[] = array(
                    'id' => $invited->id,
                    'firstname' => $invited->firstname,
                    'surname' => $invited->surname,
                    'confirmed' => $invited->confirmed,
                    'created_at' => $invited->created_at->toDateTimeString(),
                    'avatar' => '/images/uploads/user/'.$invited->images()->first()->file,
                );
            }
            $list[] = array(
                'id' => $invited_user->id,
                'firstname' => $invited_user->firstname,
                'surname' => $invited_user->surname,
                'confirmed' => $invited_user->confirmed,
                'created_at' => $invited_user->created_at->toDateTimeString(),
                'avatar' => '/images/uploads/user/'.$invited_user->images()->first()->file,
                'confirmation' => $confirmation
            );
        }
        return $list;
    }
}
