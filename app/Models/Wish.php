<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['user_id', 'text', 'active'];

    protected $casts = [
      'active' => 'boolean'
    ];

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function scopeActive($query) {
        return $query->where('active', true);
    }
}
