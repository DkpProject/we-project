<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'owner_id', 'owner_type', 'file',
    ];
    protected $dates = ['created_at', 'updated_at'];

    protected $hidden = [
        'id', 'owner_id', 'owner_type', 'created_at', 'updated_at'
    ];
	
    public function owner()
    {
        return $this->morphTo();
    }

    public function scopeModule()
    {
        $namespace = explode('\\', $this->owner_type);
        return strtolower(end($namespace));
    }
}
