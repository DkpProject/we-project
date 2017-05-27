<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollsQuestion extends Model
{
    protected $fillable = [
        'caterogy_id', 'question', 'poll_id', 'answers',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo('App\Models\CatalogCats', 'category_id');
    }

    public function poll()
    {
        return $this->belongsTo('App\Models\Poll', 'poll_id');
    }
}
