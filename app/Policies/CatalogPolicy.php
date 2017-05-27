<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Catalog;
use Illuminate\Auth\Access\HandlesAuthorization;

class CatalogPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin() && $ability != 'redirect')
            return true;
    }

    public function deal(User $user, Catalog $good)
    {
        if ($good->disabled)
            return false;
        if ($user->id == $good->user_id)
            return false;

        return true;
    }

    public function show(User $user, Catalog $good)
    {
        if ($user->id == $good->user_id)
            return true;

        if ($good->visible)
            return true;

        return false;
    }

    public function access(User $user, Catalog $good)
    {
        if ($good->disabled)
            return false;

        return true;
    }

    public function create(User $user)
    {
        return $user->confirmed;
    }
    
    public function update(User $user, Catalog $good)
    {
        if ($good->disabled)
            return false;

        if ($user->id == $good->user_id)
            return true;

        return false;
    }

    public function delete(User $user, Catalog $good)
    {
        if ($good->disabled)
            return false;

        if ($user->id == $good->user_id)
            return true;

        return false;
    }
}
