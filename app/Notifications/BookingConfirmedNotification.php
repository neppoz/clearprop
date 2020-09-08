<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class BookingConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;
    protected $user;
    protected $instructor;
    protected $plane;
    protected $type;

    public function __construct($booking)
    {
        $this->booking = $booking;
        $this->user = $booking->user;
        $this->instructor = $booking->instructor;
        $this->plane = $booking->plane;
        $this->type = $booking->type;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mailMessage = new MailMessage();

        $mailMessage
            ->subject(config('app.name') . ': Reservation confirmed')
            ->greeting('Hi,')
            ->line('the following reservation has been created and confirmed:')
            ->line(new HtmlString('<hr>'))
            ->line(new HtmlString('Pilot: ' . '<strong>' . $this->user->name . '</strong>' . '<br>'))
            ->line(new HtmlString('Plane: ' . '<strong>' . $this->plane->callsign . '</strong>' . '<br>'))
            ->line(new HtmlString('Activity: ' . '<strong>' . $this->type->name . '</strong>' . '<br>'))
            ->line(new HtmlString('Reservation from: ' . '<strong>' . $this->booking->reservation_start . '</strong>' . '<br>'))
            ->line(new HtmlString('Reservation to: ' . '<strong>' . $this->booking->reservation_stop . '</strong>' . '<br><br>'))
            ->line('')
            ->line(new HtmlString('Notes: ' . '<i>' . $this->booking->description . '</i>' . '<br>'))
            ->line('')
            ->line(new HtmlString('Status: ' . '<strong>' . \App\Booking::STATUS_RADIO[$this->booking->status] . '</strong>' . '<br>'))
            ->line('');

            if (!empty($this->instructor->name)) {
                $mailMessage->line(new HtmlString('Instructor: ' . '<strong>' . $this->instructor->name . '</strong>' . '<br>'));
            }

        $mailMessage
            ->line('Please log in to see more information.')
            ->action('Show reservation', url('/admin/bookings/'. $this->booking->id .'/edit'))
            ->line('')
            ->line('Happy landings,')
            ->line(config('app.name') . ' Team')
            ->salutation(' ');


        return $mailMessage;
    }

}
