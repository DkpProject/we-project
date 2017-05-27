<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DeliveryAddress extends Model
{
    use Notifiable;

    protected $fillable = ['deal_id', 'address', 'datetime'];
    protected $dates = ['created_at', 'updated_at', 'datetime'];

    public function deal() {
        return $this->hasOne('App\Models\Deal', 'id', 'deal_id');
    }

    public function routeNotificationForSlack()
    {
        return config('project.slackUrlToken');
    }
}
