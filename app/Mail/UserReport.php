<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserReport extends Mailable
{
    use Queueable, SerializesModels;

    public $user_details;
    public $attachment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_details, $attachment)
    {
        $this->user_details = $user_details;
        $this->subject = app('settings')['email.subject.user.report'];
        $this->bcc_address = app('settings')['email.bcc_address.user.report'];
        $this->bcc_name = app('settings')['email.bcc_name.user.report'];
        $this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->bcc_address == '' && $this->bcc_name == '') {
            return $this
                ->subject($this->subject)
                ->to($this->user_details)
                ->markdown('emails.users.report')
                ->attach($this->attachment);
        } else {
            return $this
                ->subject($this->subject)
                ->to($this->user_details)
                ->bcc($this->bcc_address, $this->bcc_name)
                ->markdown('emails.users.report')
                ->attach($this->attachment);
        }
    }
}
