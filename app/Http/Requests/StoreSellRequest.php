<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreSellRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //'customer' => 'required|integer|exists:cs_customers_details_bb,id',
            'customer_id' => 'required|integer',
            'sell_date' => 'required',
            'sell_status' => 'required',
            'reference_no' => 'required',
            'bar_code' => 'nullable',
            'product_id' => 'required|exists:item_infos,id',
            'product_name' => 'required|string|exists:item_infos,name',
            'product_qty' => 'required',
            'product_discount' => 'nullable|exists:item_infos,discount',
            'product_tax' => 'nullable|numeric|exists:item_infos,tax',
            'product_total_amount' => 'required|numeric',
            'others_charge' => 'nullable',
            'others_charge_amount' => 'nullable',
            'discount_type' => 'nullable',
            'extra_discount' => 'nullable',
            'sales_note' => 'nullable',
            'total_payable_amount' => 'required|numeric',
            'payment_type' => 'required|string',
            'payment_note' => 'nullable|string',
            'sent_sms' => 'nullable|boolean',

            // 'items' => 'required|array|min:1',
            // 'items.*.product_id' => 'required|exists:item_infos,id',
            //'items.*.product_qty' => 'required|integer|min:1|max:99',
            //'items.*.product_discount' => 'required',
        ];
    }




    // protected function prepareForValidation()
    // {
    //     $coupon = 0;
    //     $items = null;
    //     // $offer = 0;
    //     $giftWrap = $this->gift_wrap ? config('order.gift_wrap') : 0;
    //     $is_ping = false;

    //     $this->shipping_cost = config('order.shipping_cost');
    //     if ($this->hasValidItems()) {
    //         $this->products = $this->getCartProduct($this->items);
    //         $offer = $this->getOffer($this->products);
    //         $items = $this->parseItems($this->products);
    //         if ($offer == 0) {
    //             $coupon = (new OrderCoupon($this->items))->coupon;
    //         }
    //         $is_ping = $this->isPingOrder($items);
    //     }

    //     $payable = $giftWrap + 50 + $this->getSubTotal($this->products) - $offer - $coupon;

    //     $this->merge([
    //         'customer_id' => Auth::id(),
    //         'items' => $items,
    //         'payable' => $payable,
    //         'total_amount_without_vat' => $this->getSubTotal($this->products),
    //         'total_discount_amount' => $offer,
    //         'total_amount_with_vat' => $this->getSubTotal($this->products),
    //         'shipping_cost' => $this->shipping_cost,
    //         'is_ping' => $is_ping,
    //         'shipping_address' => $this->shipping_address ?? $this->address,
    //         'tracking_code' => Str::random(30),
    //         'order_date' => now(),
    //         'gift_wrap' => $giftWrap,
    //         'coupon' => $coupon,
    //         'grand_total' => $this->getSubTotal($this->products),
    //         'offer' => round($offer),
    //     ]);
    // }

    #Helper functions
    // private function isPingOrder($orderItems)
    // {
    //     $branchs = $this->getBranch($orderItems);
    //     if (count($branchs) == 2) {
    //         return true;
    //     }
    //     return false;
    // }

    // private function getCartProduct($items)
    // {
    //     $id = collect($items)->pluck('product_id')->toArray();
    //     return DB::table('item_infos as product')
    //         ->leftJoin('cs_supplier_details_bb as publisher', 'product.supplier_id', '=', 'publisher.id')
    //         ->whereIn('product.id', $id)
    //         ->select(
    //             'product.id',
    //             'product.unit_price',
    //             'product.published_price',
    //             'product.supplier_id as publisher_id',
    //             'publisher.collection_hub_id as branch_id'
    //         )
    //         ->get();
    // }

    // private function getCouponDiscount()
    // {
    //     return 0;
    // }

    // private function getBranch($orderItems)
    // {
    //     $branchs = [];
    //     foreach ($orderItems ?? [] as $item) {
    //         $branchs[] = $item['branch_id'];
    //     }
    //     return array_unique($branchs);
    // }

    // private function hasValidItems()
    // {
    //     foreach ($this->items ?? [] as $item) {
    //         if (
    //             !array_key_exists('product_id', $item)
    //             && array_key_exists('quantity', $item)
    //             && array_key_exists('item_value_local_curr', $item)
    //             && array_key_exists('total_amount_local_curr', $item)
    //             && array_key_exists('mrp_value', $item)
    //             && array_key_exists('discount', $item)
    //         ) {
    //             return false;
    //         }
    //     }
    //     return true;
    // }


    // private function getSubTotal($products)
    // {
    //     $total = 0;
    //     foreach ($this->items ?? [] as $item) {
    //         $product = $products->where('id', $item['product_id'])->first();
    //         if ($product) {
    //             $total += ($product->unit_price * $item['quantity']);
    //         }
    //     }
    //     return $total;
    // }
}
