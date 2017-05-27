<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCats extends Model
{
    protected $fillable = [
        'parent_id', 'name'
    ];
    protected $dates = ['created_at', 'updated_at'];

    public function parent()
    {
        if ($this->parent_id) {
            return $this->hasOne('App\Models\ServiceCats', 'id', 'parent_id');
        }
        return false;
    }

    public function child()
    {
        return $this->hasMany('App\Models\ServiceCats', 'parent_id', 'id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Service', 'cat_id', 'id');
    }
}
