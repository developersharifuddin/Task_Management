<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\ProductPurchased;
use App\Jobs\SendNewProductEmail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', with(['categories' => $categories,]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        // dd($request->all());
        // DB::beginTransaction();
        // try {
        $validatedData = $request->validated();

        // Create or update the item info
        $product = Product::create($validatedData);
        // Generate and save a unique slug based on item name
        $slug = Str::slug($product->name);
        $uniqueSlug = $this->makeUniqueSlug($slug);
        $product->slug = $uniqueSlug; // Generate and save a unique slug based on item name

        $product->min_qty = isset($product->min_qty) ? $product->min_qty : 1;
        $product->stock_status = isset($product->current_stock) ? true : false;
        // Generate 'code' based on item ID and a random 5-digit number
        $code = isset($product->id) ? $product->id : 'unknown_id';
        $product->code = "ITM" . $code . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $product->save();

        DB::commit();


        // Associate the product with the authenticated user
        $product->user()->associate(auth()->user());
        $product->save();

        // Dispatch the job to send email
        dispatch(new SendNewProductEmail($product));

        return redirect()->route('admin.products.index');
        // } catch (\Exception $e) {
        //     // Handle exceptions, rollback the transaction, and return an error response
        //     DB::rollBack();
        //     return response()->json(['message' => 'Error creating ItemInfo', 'error' => $e->getMessage()], 500);
        // }
    }
    private function makeUniqueSlug($originalSlug)
    {
        $count = 1;
        $slug = $originalSlug;

        // Keep incrementing the count until a unique slug is found
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function edit(Product $product)
    {
        // dd($product);
        $product = $product;
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }
    public function show(Product $product)
    {
        $product = $product;
        $categories = Category::all();
        return view('admin.products.show', compact('product', 'categories'));
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }



    public function purchaseProduct($purchaseId)
    {
        try {
            $product = Product::findOrFail($purchaseId);

            // Check if the product exists
            if (!$product) {
                // Handle the case where the product is not found
                return redirect()->route('admin.products.index')->with('error', 'Product not found.');
            }

            // Dispatch the ProductPurchased event
            event(new ProductPurchased($product));

            return redirect()->route('admin.products.index')->with('success', 'Product Purchased.');
        } catch (\Exception $e) {
            // Handle exceptions, e.g., product not found
            return redirect()->route('admin.products.index')->with('error', 'Error purchasing product.');
        }
    }
}
