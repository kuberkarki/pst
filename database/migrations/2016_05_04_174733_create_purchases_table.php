<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('purchases', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id')->unsigned();
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->string('product');
        //     $table->integer('amount');
        //     $table->text('shipping_address');
        //     $table->string('transaction_id');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       // Schema::drop('purchases');
    }
}
