<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = [
        'category_id', 'name',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo('App\Models\CatalogCats', 'category_id');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\PollsQuestion', 'poll_id');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\PollsAnswer', 'poll_id');
    }

    public function scopeFindPolls($query, $cat, $user = false)
    {
        if (!$user) $user = \Auth::user()->id;
        $passed = PollsAnswer::where('user_id', $user)->groupBy('poll_id');
        return $query->where('category_id', $cat)->whereNotIn('id', $passed->pluck('poll_id')->toArray());
    }

    public function scopePassedPolls($query, $user = false) {
        if (!$user) $user = \Auth::user()->id;
        $include = PollsAnswer::where('user_id', $user)->groupBy('poll_id');
        return $query->whereIn('id', $include->pluck('poll_id')->toArray());
    }

}
