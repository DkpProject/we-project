<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public function scopeBalance($query) {
        return $query->where('key', 'balance')->first();
    }

    public function scopeGetValue($query, $key) {
        return $query->where('key', $key)->first();
    }
}
