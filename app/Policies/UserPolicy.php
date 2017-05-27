<?php

namespace App\Policies;

use App\Helpers\MyTeam;
use App\Helpers\UsersGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Carbon\Carbon;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        $userGroup = UsersGroup::getGroup($user);
        $permissions = $userGroup->permission['policy'];
        $check = explode(":", $ability);
        if (isset($check[1])) {
            if (array_key_exists($ability, $permissions)) return true;
            return false;
        }
    }

    public function mine(User $auth, User $user)
    {
        return $auth->id == $user->id;
    }

    public function meAndMyTeam(User $auth, User $user)
    {
        return $auth->id == $user->id || MyTeam::inMyTeam($auth, $user->id);
    }

    public function myTeam(User $auth, User $user)
    {
        return MyTeam::inMyTeam($auth, $user->id);
    }
    
    public function createInvite(User $auth)
    {
        if ($auth->invites->count() < 30) return true;
        return false;
    }
    
    public function confirm(User $auth, User $user)
    {
        if ($auth->id != $user->invited_by->user->invited_by->user->id) return false;
        if (Carbon::now() >= $user->created_at->addDays(7)) return false;
        return true;
    }
    
}
