<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $fillable = [
        'user_id',
        'cat_id',
        'name',
        'descr',
        'stop_date',
        'cost',
        'used',
        'deal_type',
        'visible',
        'disabled',
        'views',
        'limitations',
        'flaw',
        'stock',
        'place',
    ];

    protected $dates = ['created_at', 'updated_at', 'stop_date'];

    protected $casts = [
        'used' => 'boolean',
        'visible' => 'boolean',
        'disabled' => 'boolean',
        'limitations' => 'boolean',
        'stock' => 'boolean',
    ];

    protected $hidden = ['updated_at', 'stop_date', 'user', 'images'];
	
    public function user()
    {
		return $this->belongsTo('App\Models\User');
    }

    public function discussion()
    {
		return $this->hasOne('App\Models\ForumDiscussion', 'evaluation_item', 'id');
    }
	
    public function cat()
    {
		return $this->belongsTo('App\Models\CatalogCats');
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
		return 'catalog';
    }
	
}
