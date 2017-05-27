<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = [
        'user_id', 'key', 'used_by',
    ];
    protected $dates = ['created_at', 'updated_at'];
	
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
	
    public function used()
    {
        return $this->hasOne('App\Models\User', 'id', 'used_by');
    }
}
