<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'user_id', 'cat_id', 'name', 'descr', 'stop_date', 'cost', 'visible', 'views',
    ];

    protected $casts = [
        'visible' => 'boolean',
        'disabled' => 'boolean',
    ];

    protected $dates = ['created_at', 'updated_at', 'stop_date'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function cat()
    {
        return $this->belongsTo('App\Models\ServiceCats');
    }

    public function images()
    {
        return $this->morphMany('App\Models\Image', 'owner');
    }

    public function deal()
    {
        return $this->morphMany('App\Models\Deal', 'item');
    }

    public function module()
    {
        return 'service';
    }
}
