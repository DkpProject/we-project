<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = ['action', 'deal_id', 'price', 'paid'];

    protected $casts = [
        'paid' => 'boolean'
    ];

    public function deal() {
        return $this->hasOne('App\Models\Deal', 'id', 'deal_id');
    }

    public function scopeToPay($query) {
        return $query->where('paid', false)->get();
    }
}
