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
    public string $msg;
    public string $access_key;

    public function __construct($subject, $access_key, $msg)
    {
        $this->access_key = $access_key;
        $this->msg = $msg;
        $this->subject = $subject;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): YouthRegistrationSuccessMail
    {
        return $this->from(env('MAIL_FROM_ADDRESS', 'noreply@skills.gov.bd'))
            ->subject($this->subject)
            ->view('course_management::frontend.email.youth-registration-success');
    }
}
