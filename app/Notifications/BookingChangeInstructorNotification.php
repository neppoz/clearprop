<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class BookingChangeInstructorNotification extends Notification
{
    use Queueable;

    protected $event;
    protected $user;
    protected $plane;
    protected $type;
    protected $instructor;
    protected $instructor_url;


    public function __construct($event, $user, $type, $plane, $instructor, $instructor_url)
    {
        //$this->data = $data;
        $this->event = $event;
        $this->user = $user;
        $this->type = $type;
        $this->plane = $plane;
        $this->instructor = $instructor;
        $this->url = $instructor_url;
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
            ->subject(config('app.name') . ': Instructor confirmation')
            ->greeting('Hi,')
            ->line('a reservation has been confirmed.')
            ->line('')
            ->line(new HtmlString('Pilot: ' . '<strong>' . $this->user->name . '</strong>' . '<br>'))
            ->line(new HtmlString('Plane: ' . '<strong>' . $this->plane->callsign . '</strong>' . '<br>'))
            ->line(new HtmlString('Activity: ' . '<strong>' . $this->type->name . '</strong>' . '<br>'))
            ->line(new HtmlString('Reservation from: ' . '<strong>' . $this->event->booking->reservation_start . '</strong>' . '<br>'))
            ->line(new HtmlString('Reservation to: ' . '<strong>' . $this->event->booking->reservation_stop . '</strong>' . '<br><br>'))
            ->line('')
            ->line(new HtmlString('Notes: ' . '<i>' . $this->event->booking->description . '</i>' . '<br>'))
            ->line('')
            ->line(new HtmlString('Status: ' . '<strong>' . \App\Booking::STATUS_RADIO[$this->event->booking->status] . '</strong>' . '<br>'))
            ->line(new HtmlString('Instructor: ' . '<strong>' . $this->instructor->name . '</strong>' . '<br>'))
            ->line('')
            ->line('Please log in to see more information.')
            ->action('Show reservation', $this->url)
            ->line('')
            ->line('Happy landings,')
            ->line(config('app.name') . ' Team')
            ->salutation(' ');
    }
}
