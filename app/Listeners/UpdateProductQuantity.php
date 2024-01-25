<?php

namespace App\Listeners;

use App\Events\ProductPurchased;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateProductQuantity implements ShouldQueue
{
    public function handle(ProductPurchased $event)
    {
        $product = $event->product;

        // Implement logic to update the product quantity as needed
        // For example, decrement the quantity by 1 after a purchase
        $product->update([
            'current_stock' => $product->current_stock + 1,
        ]);
    }
}
