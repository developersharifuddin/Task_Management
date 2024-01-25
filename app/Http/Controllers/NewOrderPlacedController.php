<?php

namespace App\Http\Controllers;

use App\Models\OrderMaster;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\NewOrderPlaced;

class NewOrderPlacedController extends Controller
{
    public function index()
    {
        return view('admin.orders.list');
    }
    public function store(Request $request)
    {
        // Validate the incoming request data (you can modify the validation rules as needed)
        // $validatedData = $request->validate([
        //     // Define your validation rules for order creation fields
        //     'product_name' => 'required|string',
        //     'quantity' => 'required|numeric',
        //     // Add more fields as necessary
        // ]);
        $newOrder = new OrderMaster();
        $newOrder->id = rand(1000, 9999);
        $newOrder->customer_id = '34';
        $newOrder->issue_master_id = '34';
        $newOrder->order_date = '2023-11-05 16:25:30.000000';
        $newOrder->order_type_id = '1';
        $newOrder->store_id = '1';
        $newOrder->customer_id = '34';
        $newOrder->customer_phone = '01965674161';
        $newOrder->email = 'customer1@gmail.com';
        $newOrder->total_amount_without_vat = '343';
        $newOrder->order_status = 'pending';
        $newOrder->status = '0';
        $newOrder->payable = '343';
        $newOrder->is_active = '1';
        $newOrder->created_at = '2023-11-05 21:45:37';
        $newOrder->updated_at = '2023-11-05 21:45:37';
        $newOrder->save();
        // Dispatch the event after the order is created
        event(new NewOrderPlaced($newOrder));

        // Return a response indicating success or redirect to a success page
        return response()->json(['message' => $newOrder, 'Order created successfully']);
    }
}
