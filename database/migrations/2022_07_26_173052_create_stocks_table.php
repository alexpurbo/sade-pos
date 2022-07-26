<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Stocks', function (Blueprint $table) {
            $table->id('id_stock');
            
            $table->unsignedBigInteger('id_merchant');
            $table->foreign('id_merchant')->references('id_merchant')->on('Merchants');
            
            $table->unsignedBigInteger('id_product');
            $table->foreign('id_product')->references('id_product')->on('Products');
            
            $table->string('stock', 20);
            $table->string('capital_price');
            $table->string('price');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Stocks');
    }
}
