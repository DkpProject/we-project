<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealsMessages extends Model
{
    protected $fillable = [
        'deal_id', 'user_id', 'comment', 'rating', 'finish',
    ];
    protected $dates = ['created_at', 'updated_at'];
    
    function deal() {
        return $this->belongsTo('App\Models\Deal');
    }
    
    function user() {
        return $this->belongsTo('App\Models\User');
    }
}
