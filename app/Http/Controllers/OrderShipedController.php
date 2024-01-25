<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use App\Events\OrderDelivered;
use Illuminate\Support\Facades\DB;

use App\Jobs\SendOrderShippedEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderShipedController extends Controller
{

    public function OrderList()
    {
        $orders = OrderMaster::where('status', '0')->paginate(10);
        return view('admin.order.list', ['orders' => $orders,]);
    }


    public function sendOrderShippedEmails()
    {
        SendOrderShippedEmail::dispatch()->onQueue('emails');

        // Optionally return a success message or redirect to a success page
    }




    public function sendOrderEmail($orderId)
    {
        try {
            // Fetch the order and update the status
            $order = OrderMaster::find($orderId);

            // Update the order status to 'Delivered'
            $order->order_status = 'Delivered';
            $order->save();

            // Dispatch the event if the status has changed to 'Delivered'
            if ($order->wasChanged('order_status') && $order->order_status === 'Delivered') {
                event(new OrderDelivered($order));
            }

            return redirect()->back()->with('success', 'Order status updated and event dispatched.');
        } catch (\Exception $e) {
            Log::error('Error sending order delivered email: ' . $e->getMessage());
            return redirect()->back()->with('error', "An error occurred. Please check the logs for more details.");
        }
    }
}
