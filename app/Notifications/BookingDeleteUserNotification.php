<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class BookingDeleteUserNotification extends Notification
{
    use Queueable;

    protected $event;
    protected $user;
    protected $plane;
    protected $type;


    public function __construct($event, $user, $type, $plane)
    {
        //$this->data = $data;
        $this->event = $event;
        $this->user = $user;
        $this->type = $type;
        $this->plane = $plane;
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
            ->subject(config('app.name') . ': Reservation deleted')
            ->greeting('Hi,')
            ->line(new HtmlString('we would like to inform you that a ' .strtolower(trans('cruds.booking.title_singular')). ' has been <strong>cancelled</strong>.'))
            ->line('')
            ->line(new HtmlString('Pilot: ' . '<strong>' . $this->user->name . '</strong>' . '<br>'))
            ->line(new HtmlString('Plane: ' . '<strong>' . $this->plane->callsign . '</strong>' . '<br>'))
            ->line(new HtmlString('Activity: ' . '<strong>' . $this->type->name . '</strong>' . '<br>'))
            ->line(new HtmlString('Reservation from: ' . '<strong>' . $this->event->booking->reservation_start . '</strong>' . '<br>'))
            ->line(new HtmlString('Reservation to: ' . '<strong>' . $this->event->booking->reservation_stop . '</strong>' . '<br><br>'))
            ->line(new HtmlString('Notes: ' . '<i>' . $this->event->booking->description . '</i>' . '<br><br>'))
            ->line(new HtmlString('<strong>No further action is required</strong><br>'))
            //->action(trans('global.show'). ' '. strtolower(trans('cruds.booking.title_singular')), config('app.url') . '/admin/bookings/'. $this->event->booking->id .'/edit')
            ->line('Happy landings,')
            ->line(config('app.name') . ' Team')
            ->salutation(' ');
    }
}
