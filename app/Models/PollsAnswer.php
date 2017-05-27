<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollsAnswer extends Model
{
    protected $fillable = [
        'user_id', 'poll_id', 'question_id', 'answer',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function poll()
    {
        return $this->belongsTo('App\Models\Poll', 'poll_id');
    }

    public function question()
    {
        return $this->belongsTo('App\Models\PollsQuestion', 'question_id');
    }

    public function scopeCategory($query, $cat)
    {
        $include = Poll::where('category_id', $cat);
        return $query->whereIn('poll_id', $include->pluck('id')->toArray());
    }
}
