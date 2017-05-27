<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersRolesRule extends Model
{
    protected $fillable = [
        'type', 'if', 'value',
    ];
    protected $dates = ['created_at', 'updated_at'];

    function role() {
        return $this->hasOne('App\Models\UsersRole', 'id', 'role_id');
    }
}
