<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Deal extends Model
{
    protected $fillable = [
        'seller_id',
        'purchaser_id',
        'item_id',
        'cost',
        'module',
        'type',
        'action',
        'status',
        'closed_by',
        'state',
    ];

    protected $dates = ['created_at', 'updated_at'];
	
    public function seller()
    {
		return $this->hasOne('App\Models\User', 'id', 'seller_id');
    }
	
    public function purchaser()
    {
		return $this->hasOne('App\Models\User', 'id', 'purchaser_id');
    }
	
    public function closed()
    {
		return $this->hasOne('App\Models\User', 'id', 'closed_by');
    }
	
    public function messages()
    {
		return $this->hasMany('App\Models\DealsMessages', 'deal_id', 'id')->orderBy('id', 'desc');
    }
	
    public function item()
    {
		return $this->morphTo();
    }

    public function receipts()
    {
		return $this->hasMany('App\Models\Receipt', 'deal_id', 'id');
    }

    public function addresses()
    {
		return $this->hasMany('App\Models\DeliveryAddress', 'deal_id', 'id');
    }

    public function scopeModule()
    {
        $namespace = explode('\\', $this->item_type);
        return strtolower(end($namespace));
    }
}
