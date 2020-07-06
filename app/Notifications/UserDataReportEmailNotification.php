<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserDataReportEmailNotification extends Notification
{
    use Queueable;

    protected $data;
    protected $attachment;
    protected $sender;

    public function __construct($data, $attachment, $sender)
    {
        $this->data = $data;
        $this->attachment = $attachment;
        $this->sender = $sender;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return $this->getMessage();
    }

    public function getMessage()
    {
        return (new MailMessage)
            ->subject(config('app.name') . ': Report for ' . $this->data['name'])
            ->bcc($this->sender)
            ->greeting('Hi,')
            ->line(new HtmlString('we send you the detailed report of all your activities registered until ' . '<strong>' . $this->data['date'] . '</strong>'))
            ->line('Please log in to see more information.')
            ->action(config('app.name'), config('app.url'))
            ->line('Thank you')
            ->line(config('app.name') . ' Team')
            ->salutation(' ')
            ->attach($this->attachment);
    }
}
