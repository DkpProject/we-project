<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Service;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin() && $ability != 'redirect')
            return true;
    }

    public function deal(User $user, Service $service)
    {
        if ($service->disabled)
            return false;
        if ($user->id == $service->user_id)
            return false;

        return true;
    }

    public function show(User $user, Service $service)
    {
        if ($user->id == $service->user_id)
            return true;

        if ($service->visible)
            return true;

        return false;
    }

    public function access(User $user, Service $service)
    {
        if ($service->disabled)
            return false;

        return true;
    }

    public function create(User $user)
    {
        return $user->confirmed;
    }

    public function update(User $user, Service $service)
    {
        if ($service->disabled)
            return false;

        if ($user->id == $service->user_id)
            return true;

        return false;
    }

    public function delete(User $user, Service $service)
    {
        if ($service->disabled)
            return false;

        if ($user->id == $service->user_id)
            return true;

        return false;
    }
}
