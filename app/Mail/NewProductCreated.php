<?php
// app/Mail/NewProductCreated.php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewProductCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function build()
    {
        return $this->subject('New Product Created')->view('emails.new_product_created');
        // Make sure you have a Blade view at resources/views/emails/new_product_created.blade.php
    }
}
