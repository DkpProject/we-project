<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumDiscussion extends Model {

	protected $table = 'forum_discussion';
	protected $fillable = ['title', 'category_id', 'user_id', 'slug', 'sticky', 'evaluation', 'evaluation_item', 'views', 'answered'];
    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'answered' => 'boolean',
        'sticky' => 'boolean',
    ];

	public function user(){
		return $this->belongsTo('App\Models\User');
	}

	public function category()
	{
		return $this->belongsTo('App\Models\Category', 'category_id');
	}

	public function posts()
	{
		return $this->hasMany('App\Models\ForumPost', 'discussion_id');
	}

	public function post(){
		return $this->hasMany('App\Models\ForumPost', 'discussion_id')->orderBy('created_at', 'ASC');
	}

	public function postsCount()
	{
	  return $this->posts()
	    ->selectRaw('discussion_id, count(*)-1 as total')
	    ->groupBy('discussion_id');
	}

	public function item()
	{
	  return $this->hasOne('App\Models\Catalog', 'id', 'evaluation_item');
	}

}
