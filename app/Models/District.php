<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'name', 'parent_id',
    ];
    protected $dates = ['created_at', 'updated_at'];
    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];
}
