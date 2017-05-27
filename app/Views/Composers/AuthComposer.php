<?php

namespace App\Views\Composers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;
use Illuminate\Users\Repository as UserRepository;

class AuthComposer
{
    protected $auth;

    public function __construct(Authenticatable $auth = null)
    {
        $this->auth = $auth;
    }

    public function compose(View $view)
    {
        $view->with('auth', $this->auth);
    }
}