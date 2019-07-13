<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->string('code');

            $table->string('total_price');
            $table->string('discount');
            $table->string('discount_unit');
            $table->integer('payment_method');
            $table->string('payable');
            $table->string('paid');
            $table->string('due');

            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('customer_id')->references('id')->on('customers')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
