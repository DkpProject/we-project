<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Deal;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin() && $ability != 'redirect') {
            return true;
        }
    }
    
    public function view(User $user, Deal $deal)
    {
        if ($user->id == $deal->seller_id) {
            return true;
        }
        if ($user->id == $deal->purchaser_id) {
            return true;
        }
        return false;
    }
    
    public function seller(User $user, Deal $deal)
    {
        if ($user->id == $deal->seller_id) {
            return true;
        }
        return false;
    }
    
    public function purchaser(User $user, Deal $deal)
    {
        if ($user->id == $deal->purchaser_id) {
            return true;
        }
        return false;
    }
}
