<?php

namespace App\Notifications\Slack;

use App\Helpers\DealHelper;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeliveryToSlackNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }


    public function toSlack($address) {
        return (new SlackMessage())
            ->from('Сервисный бот', ':bell:')
            ->to('#delivery')
            ->content(':truck:  Получена новая заявка на доставку товара!')
            ->attachment(function ($attachment) use ($address) {
                $attachment->color('danger')
                    ->fields([
                        ':mailbox_with_mail:  Адрес доставки:' => $address->address,
                        ':clock3:  Удобное время:' => $address->datetime->format('d / m / Y, H:i'),
                    ]);
            })->attachment(function ($attachment) use ($address) {
                $attachment->title(':dollar: Информация о сделке', url('/deal/'.$address->deal->id))
                    ->color('good')
                    ->footer('Дата создания: '.Carbon::now()->format('d / m / Y - H:i'))
                    ->fields([
                        ':arrow_up: Продавец' => '<'.url('/profile/'.$address->deal->seller->id).'|'.$address->deal->seller->surname.' '.$address->deal->seller->firstname.'> (<tel:'.$address->deal->seller->phone.'|'.$address->deal->seller->phone.'>)',
                        ':arrow_down: Покупатель' => '<'.url('/profile/'.$address->deal->purchaser->id).'|'.$address->deal->purchaser->surname.' '.$address->deal->purchaser->firstname.'> (<tel:'.$address->deal->purchaser->phone.'|'.$address->deal->purchaser->phone.'>)',
                        ':moneybag: Стоимость' => $address->deal->cost.' ₽',
                        ':grey_exclamation: Тип сделки' => DealHelper::type($address->deal),
                    ]);
            })
            ->attachment(function ($attachment) use ($address) {
                $attachment->title(':information_source: Информация о товаре')
                    ->color('warning')
                    ->fields([
                        ':mega: Название товара' => '<'.url('/'.$address->deal->item->module().'/'.$address->deal->item->id).'|'.$address->deal->item->name.'>',
                        ':package: Место на складе' => $address->deal->item->place,
                    ]);
            });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
