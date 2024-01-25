<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuccessfulTaskNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('emails.successful_task_notification')
            ->subject('Successful Task Notification'); // Set the email subject
    }
}
