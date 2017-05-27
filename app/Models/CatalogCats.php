<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogCats extends Model
{
    protected $fillable = [
        'parent_id', 'name'
    ];
    protected $dates = ['created_at', 'updated_at'];
    protected $hidden = ['id', 'created_at', 'updated_at', 'pivot'];
	
    public function parent()
    {
		if ($this->parent_id) {
			return $this->hasOne('App\Models\CatalogCats', 'id', 'parent_id');
		}
		return false;
    }

    public function scopeOrdered($query) {
        return $query->orderBy('name');
    }
	
    public function child()
    {
		return $this->hasMany('App\Models\CatalogCats', 'parent_id', 'id')->orderBy('name');
    }
	
    public function items()
    {
		return $this->hasMany('App\Models\Catalog', 'cat_id', 'id');
    }
	
}
