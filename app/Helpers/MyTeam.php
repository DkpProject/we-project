<?php

namespace App\Helpers;

use App\Models\User;

class MyTeam
{
    public static function getMyTeam($user) {
        $collection = collect();
        foreach ($user->invites as $invite)
            if ($invite->used_by != 0)
                $collection->push($invite->used);
        if ($user->id != 1)
            $collection->push($user->invited_by->user);

        return $collection;
    }

    public static function inMyTeam($user, $id) {
        $myTeam = self::getMyTeam($user);
        return in_array($id, $myTeam->pluck('id')->toArray());
    }

    public static function generate_key($number) {
        $symbols = array('a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z',
            '1','2','3','4','5','6',
            '7','8','9','0');
        $key = "";
        for($i = 0; $i < $number; $i++)
        {
            $index = rand(0, count($symbols) - 1);
            $key .= $symbols[$index];
        }
        return $key;
    }
}