<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// Schema::rename($from, $to);
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            // $table->charset = 'utf8';
            // $table->charset = 'utf8mb4';
            // $table->collation = 'utf8_unicode_ci';
            // $table->temporary();
            $table->comment('Parent_id categories table id');

            $table->id();
            $table->string('name_english');
            $table->string('name_bangla');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->index('parent_id');
            $table->index('type');
            $table->text('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('descriptions')->nullable();
            $table->boolean('home_status')->default(1);
            $table->string('logo')->default('category.png');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->foreign('parent_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
