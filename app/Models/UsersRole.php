<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersRole extends Model
{
    protected $fillable = [
        'name', 'sort', 'default'
    ];

    protected $casts = [
        'default' => 'boolean',
        'changeable' => 'boolean',
        'permission' => 'array',
    ];
    protected $dates = ['created_at', 'updated_at'];

    function rules() {
        return $this->hasMany('App\Models\UsersRolesRule', 'role_id', 'id');
    }

    function scopeChangeable($query) {
        return $query->where('changeable', true);
    }
}
