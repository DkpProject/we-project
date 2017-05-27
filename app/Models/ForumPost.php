<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model {

	protected $table = 'forum_post';
	protected $fillable = ['discussion_id', 'user_id', 'body', 'price', 'thanks', 'first'];
    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'first' => 'boolean',
        'thanks' => 'boolean',
    ];

	public function discussion()
	{
		return $this->belongsTo('App\Models\ForumDiscussion', 'discussion_id');
	}

	public function user(){
		return $this->belongsTo('App\Models\User');
	}

}