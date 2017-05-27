<?php

namespace App\Notifications\Slack;

use App\Models\Catalog;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackAttachmentField;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;

class ReportFromUserNotification extends Notification
{
    use Queueable;
    /**
     * @var
     */
    private $subject;
    /**
     * @var
     */
    private $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subject, $message)
    {
        $this->subject = $subject;
        $this->message = $message;
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
        if($this->subject instanceof User) {
            $subject = "Пользователь: <" . url('/profile/' . $this->subject->id) . "|" . $this->subject->surname . " " . $this->subject->firstname . ">";
        } elseif ($this->subject instanceof Catalog) {
            $subject = "Товар: <".url('/catalog/'.$this->subject->id)."|".$this->subject->name.">";
        } elseif ($this->subject instanceof Service) {
            $subject = "Услуга: <".url('/service/'.$this->subject->id)."|".$this->subject->name.">";
        }

        return (new SlackMessage())
            ->from('Сервисный бот', ':bell:')
            ->to('#reports')
            ->content(':warning:  Получена жалоба от пользователя!')
            ->attachment(function ($attachment) use ($notifiable, $subject) {
                $attachment
                    ->color('danger')
                    ->footer('Жалоба сформирована: '.Carbon::now()->format('d / m / Y, H:i'))
                    ->fields([
                        ':arrow_right: Отправитель:' => '<'.url('/profile/'.$notifiable->id).'|'.$notifiable->surname . ' ' . $notifiable->firstname . '>',
                        ':triangular_flag_on_post:  Предмет жалобы:' => $subject,
                        (new SlackAttachmentField())
                            ->title(':memo:  Сообщение:')
                            ->content($this->message)
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
