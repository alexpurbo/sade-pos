<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_purchases', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_merchant');
            $table->foreign('id_merchant')->references('id_merchant')->on('merchants');

            $table->unsignedBigInteger('id_product');
            $table->foreign('id_product')->references('id_product')->on('products');

            $table->integer('quantity');
            $table->double('price');
            $table->double('total');

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
        Schema::dropIfExists('stock_purchases');
    }
}
