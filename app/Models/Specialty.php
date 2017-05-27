<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable = [
        'user_id', 'spec_id', 'level',
    ];
    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function spec()
    {
        return $this->hasOne('App\Models\CatalogCats', 'id', 'spec_id');
    }
}
