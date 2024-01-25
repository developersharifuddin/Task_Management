<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;

class BulkEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        try {
            // Your email construction logic here
            return $this->markdown('mails.bulk_email')->with(['user' => $this->user]);
        } catch (\Exception $e) {
            Log::error('Error creating email for ' . $this->user->email . ': ' . $e->getMessage());
            // You can also throw the exception to bubble up and be handled elsewhere if needed
            // throw $e;
        }
    }
}
