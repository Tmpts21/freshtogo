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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('payment_status');
            $table->string('status');
            $table->string('mop');
            $table->string('gcash_proof_of_payment');
            $table->string('gcash_reference_number');
            $table->string('total_price'); 
            $table->string('deliveryFee'); 
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
        Schema::dropIfExists('deliveries');
    }
};
