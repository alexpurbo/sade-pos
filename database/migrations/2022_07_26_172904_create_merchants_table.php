<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id('id_merchant');

            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            
            $table->string('merchant_name');
            $table->string('email');
            $table->string('phone_number', 15);
            $table->char('merchant_type', 2)->nullable($value = false);
            $table->boolean('is_verified');
            $table->boolean('is_star_merchant');
            $table->boolean('is_banned');
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
        Schema::dropIfExists('Merchants');
    }
}
