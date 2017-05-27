<?php

namespace App\Helpers;


class UsersGroup
{
    public static function getGroupName($user) {
        switch(true) {
            case (!$user->group_id):
                return new UsersRoles($user);
                break;
            case ($user->group_id):
                return $user->myGroup->name;
                break;
        }
    }

    public static function getGroup($user) {
        switch(true) {
            case (!$user->group_id):
                $group = new UsersRoles($user);
                return $group->getRole();
                break;
            case ($user->group_id):
                return $user->myGroup;
                break;
        }
    }
}