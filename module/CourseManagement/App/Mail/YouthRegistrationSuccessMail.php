<?php

namespace Module\CourseManagement\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class YouthRegistrationSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $msg;

    public function __construct()
    {

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): YouthRegistrationSuccessMail
    {
        return $this->from(env('MAIL_FROM_ADDRESS', 'animesh.pust@gmail.com'))
            ->subject('NISE3 Registration Confirmation')
            ->view('frontend.email.youth-registration-success')
            ->with([
                'msg' => 'You registered successfully in NISE3',
                'link' => '/inboxes/'
            ]);
    }
}
