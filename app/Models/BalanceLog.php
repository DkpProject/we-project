<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceLog extends Model
{
    protected $table = 'balance_log';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'item_id', 'user_id', 'action', 'value',
    ];

    function user() {
        return $this->belongsTo('App\Models\User');
    }
}
