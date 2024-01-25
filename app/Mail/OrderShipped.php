<?php

namespace App\Mail;

use App\Models\OrderMaster;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\PendingMail;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(OrderMaster $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Order Has Been Shipped'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order.shipped'
        );
    }

    public function build()
    {
        $this->withSwiftMessage(function ($message) {
            // Example of setting the priority
            $message->setPriority(1);
        });

        return $this->buildView();
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
