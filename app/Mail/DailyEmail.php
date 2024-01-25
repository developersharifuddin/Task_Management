<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.daily') // This assumes you have a blade file named 'daily.blade.php'
            ->subject('Your Daily Update') // Subject of the email
            ->with([
                'user' => $this->user,
                // Add more data if needed for the email template
            ]);
    }
}
