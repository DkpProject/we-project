<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'from', 'to', 'text', 'read', 'type', 'used', 'variable'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function author()
    {
        return $this->hasOne('App\Models\User' , 'id', 'from');
    }

    public function recipient()
    {
        return $this->hasOne('App\Models\User' , 'id', 'to');
    }

    public function scopeLastMessage($query, $auth, $user)
    {
        return $query
            ->where(function ($q) use ($auth, $user) {
                $q->where('from', $auth)
                    ->where('to', $user)
                    ->where('type', 0);
            })
            ->orWhere(function ($q) use ($auth, $user) {
                $q->where('from', $user)
                    ->where('to', $auth);
            })
            ->orderBy('id', 'desc')->first();
    }

    public function scopeAllMessages($query, $auth, $user)
    {
        return $query
            ->where(function ($q) use ($auth, $user) {
                $q->where('from', $auth)
                    ->where('to', $user);
            })
            ->orWhere(function ($q) use ($auth, $user) {
                $q->where('from', $user)
                    ->where('to', $auth);
            })->take(30)->get();
    }
}
