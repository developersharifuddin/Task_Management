<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'item_infos';
    // protected $fillable = ['category_id', 'purchase_price', 'current_stock'];
    protected $fillable = [
        'code', 'name',
        'name_bangla', 'slug', 'category_id', 'min_qty',
        'weight', 'published_price', 'sell_price',
        'purchase_price', 'discount',
        'discount_type', 'current_stock',
        'images', 'thumbnail',
        'published', 'status', 'stock_status',
        'sub_title', 'request_status',
        'approved', 'user_id'
    ];


    // Item.php
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
