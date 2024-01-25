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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('sell_id');
            $table->integer('customer_id')->nullable();
            $table->double('total_payable_amount', 20, 2)->default(0);
            $table->double('total_paid_amount', 20, 2)->default(0);
            $table->double('total_due_amount', 20, 2)->default(0);
            $table->longText('payment_details')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_note')->nullable();
            $table->string('txn_code', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
