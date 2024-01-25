<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskFailedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('emails.task_failed_notification')
            ->subject('Task Execution Failed'); // Subject of the email
        // Additional configurations or variables for the email content can be added here
    }
}
