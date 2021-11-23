<?php

namespace Module\SmefManagement\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class YouthApplicationAcceptMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public string $msg;
    public string $accessKey;
    public string $youthName;

    public function __construct($subject, $accessKey, $msg, $youthName)
    {
        $this->accessKey = $accessKey;
        $this->msg = $msg;
        $this->subject = $subject;
        $this->youthName = $youthName;
    }



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): YouthApplicationAcceptMail
    {
        return $this->from(env('MAIL_FROM_ADDRESS', 'noreply@skills.gov.bd'))
            ->subject($this->subject)
            ->view('course_management::frontend.email.youth-course-enroll-accept');
    }
}
