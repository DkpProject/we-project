<?php

namespace App\Models\DeliveryAddress;

use App\Models\DeliveryAddress;
use App\Notifications\Slack\DeliveryToSlackNotification;
use Illuminate\Support\Facades\Notification;

class DeliveryNotifyObserver
{
    public function created(DeliveryAddress $address)
    {
        Notification::send($address, new DeliveryToSlackNotification());
    }

    public function updated(DeliveryAddress $address)
    {
        Notification::send($address, new DeliveryToSlackNotification());
    }
}