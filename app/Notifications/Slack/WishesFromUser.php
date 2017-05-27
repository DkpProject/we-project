<?php

namespace App\Notifications\Slack;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use Illuminate\Notifications\Messages\SlackAttachmentField;

class WishesFromUser extends Notification
{
    use Queueable;
    /**
     * @var
     */
    private $message, $notag_message, $images;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        //
        $this->message = html_entity_decode($message);
        $message = preg_replace('/<img[^>]+src\s*=\s*["\']http([^"\']+)["\'][^>]*>/x', ' &lt;$1|Изображение&gt; ', $this->message);
        $message = preg_replace('/<img[^>]+src\s*=\s*["\'][^http]([^"\']+)["\'][^>]*>/x', ' &lt;https://we-project.ru/$1|Изображение&gt; ', $this->message);
        $this->notag_message = html_entity_decode(strip_tags($message));
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage())
            ->from('Сервисный бот', ':bell:')
            ->to('#service')
            ->content(':warning:  Получены пожелания от пользователя!')
            ->attachment(function ($attachment) use ($notifiable) {
                $attachment
                    ->color('good')
                    ->footer('Пожелания сформированы: '.Carbon::now()->format('d / m / Y, H:i'))
                    ->fields([
                        ':arrow_right: Отправитель:' => '<'.url('/profile/'.$notifiable->id).'|'.$notifiable->surname . ' ' . $notifiable->firstname . '>',
                        (new SlackAttachmentField())
                            ->title(':memo:  Сообщение:')
                            ->content($this->notag_message)
                            ->long(),
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
