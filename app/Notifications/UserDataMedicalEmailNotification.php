<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserDataMedicalEmailNotification extends Notification
{
    use Queueable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toArray($notifiable)
    {
        return [
            'name' => $this->data['name'],
            'medical_due' => Carbon::createFromFormat(config('panel.date_format'), $this->data['medical_due'])->format('Y-m-d'),
        ];
    }

    public function toMail($notifiable)
    {
        return $this->getMessage();
    }

    public function getMessage()
    {
        return (new MailMessage)
            ->subject(config('app.name') . ': Member ' . $this->data['name'] . ' has expired medical')
            ->greeting('Hi,')
            ->line(new HtmlString('we would like to inform you that ' . '<strong>' . $this->data['name'] . '</strong>' . ' has an expired medical'))
            ->line(new HtmlString('The expiration date is: ' . '<strong>' . $this->data['medical_due'] . '</strong>'))
            ->line('Please log in to see more information.')
            ->action(config('app.name'), config('app.url'))
            ->line('Thank you')
            ->line(config('app.name') . ' Team')
            ->salutation(' ');
    }
}
