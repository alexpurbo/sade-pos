<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Transactions', function (Blueprint $table) {
            $table->id('id_transaction');
            
            $table->unsignedBigInteger('id_merchant');
            $table->foreign('id_merchant')->references('id_merchant')->on('Merchants');
            
            $table->unsignedBigInteger('id_product');
            $table->foreign('id_product')->references('id_product')->on('Products');
            
            $table->string('date_transaction', 20);
            $table->char('type', 5);
            $table->string('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Transactions');
    }
}
