<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80)->nullable();
            $table->string('name_bangla', 80)->nullable();
            $table->string('slug', 120)->nullable();
            $table->string('code', 255)->nullable();
            $table->string('category_id')->nullable();
            $table->string('min_qty', 80)->nullable();
            $table->string('weight', 80)->nullable()->default('0');
            $table->float('published_price', 10, 0)->nullable()->default(0);
            $table->integer('sell_price')->default(0);
            $table->integer('purchase_price')->default(0);
            $table->double('discount')->default(0);
            $table->integer('discount_type')->nullable();
            $table->integer('current_stock')->nullable();
            $table->string('images')->nullable();
            $table->string('thumbnail')->default('default.png');
            $table->boolean('published')->default(false);
            $table->boolean('status')->default(true);
            $table->integer('stock_status')->default(1);
            $table->string('sub_title', 200)->nullable();
            $table->boolean('request_status')->default(false);
            $table->boolean('approved')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('approval_at')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_infos');
    }
};
