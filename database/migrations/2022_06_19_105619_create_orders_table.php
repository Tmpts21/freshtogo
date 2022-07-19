<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable(); 
            $table->foreignId('user_id')->nullable(); 
            $table->string('status'); 
            $table->string('customer_name'); 
            $table->string('driver_name')->nullable(); 
            $table->string('driver_id')->nullable(); 
            $table->string('product_name');
            $table->string('total_price');
            $table->string('deliveryFee');
            $table->string('quantity');
            $table->string('mop');
            $table->string('image');
            $table->string('address');
            $table->string('remarks')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
