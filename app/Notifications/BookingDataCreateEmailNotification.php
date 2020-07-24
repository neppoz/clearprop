<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class BookingDataCreateEmailNotification extends Notification
{
    use Queueable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
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
            ->subject(config('app.name') . ': Reservation created')
            ->greeting('Hi,')
            ->line('we would like to confirm that a reservation has been created successfully.')
            ->line('')
            ->line(new HtmlString('Pilot: ' . '<strong>' . $this->data['pilot'] . '</strong>' . '<br>'))
            ->line(new HtmlString('Plane: ' . '<strong>' . $this->data['plane'] . '</strong>' . '<br>'))
            ->line(new HtmlString('Reservation from: ' . '<strong>' . $this->data['reservation_start'] . '</strong>' . '<br>'))
            ->line(new HtmlString('Reservation to: ' . '<strong>' . $this->data['reservation_stop'] . '</strong>' . '<br><br>'))
            ->line('Please log in to see more information.')
            ->action(config('app.name'), config('app.url'))
            ->line('Thank you')
            ->line(config('app.name') . ' Team')
            ->salutation(' ');
    }
}
