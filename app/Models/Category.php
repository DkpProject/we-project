<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $table = 'catalog_cats';

	protected $fillable = ['parent_id', 'name'];
	protected $hidden = ['id', 'created_at', 'updated_at'];

	public function discussions()
	{
		return $this->hasMany('App\Models\ForumDiscussion');
	}

	public function scopeOnlyChild($query) {
	    return $query->where('parent_id', '<>', '0');
    }

	public function scopeOrdered($query) {
	    return $query->orderBy('name');
    }

	public function childs() {
	    return $this->hasMany('App\Models\Category', 'parent_id', 'id')->orderBy('name');
    }

}