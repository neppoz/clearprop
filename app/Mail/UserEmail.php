<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Snowfire\Beautymail\Beautymail;

class UserEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $to_addr;
    public $to_name;
    public $bcc_addr;
    public $bcc_name;
    public $attachment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $to_addr, $to_name, $bcc_addr, $bcc_name, $attachment)
    {
        $this->subject = $subject;
        $this->to_addr = $to_addr;
        $this->to_name = $to_name;
        $this->bcc_addr = $bcc_addr;
        $this->bcc_name = $bcc_name;
        $this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $beautymail = app()->make(Beautymail::class);

        if($this->bcc_addr=='' || $this->bcc_name =='') {

            return $this
                ->from(env('MAIL_FROM_ADDRESS'))
                ->subject($this->subject)
                ->to($this->to_addr, $this->to_name)
                ->view('emails.report', $beautymail->getData())
                ->attach($this->attachment);

        } else {

            return $this
                ->from(env('MAIL_FROM_ADDRESS'))
                ->subject($this->subject)
                ->to($this->to_addr, $this->to_name)
                ->bcc($this->bcc_addr, $this->bcc_name)
                ->view('emails.report', $beautymail->getData())
                ->attach($this->attachment);

        }

    }
}
