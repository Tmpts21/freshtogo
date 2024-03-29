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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->string('name');
            $table->string('description');
            $table->string('brand');
            $table->string('stock');
            $table->string('price'); 
            $table->integer('sold')->default(0); 
            $table->string('image')->default('image/products/dZMQdmrdJVa7WRtI2IAsJhEIBiirQyGfS7yVQKwB.jpg'); 
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
        Schema::dropIfExists('products');
    }
};
