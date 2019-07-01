<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_id')->unsigned();
            $table->integer('productcategory_id')->unsigned();
            $table->integer('vendor_id')->unsigned();
            $table->string('name');
            $table->string('brand');
            $table->string('unit');
            $table->string('sku')->nullable();
            $table->string('expire_date')->nullable();
            $table->string('stock_alert')->nullable();
            $table->string('quantity');
            $table->string('buying_price');
            $table->string('selling_price');
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('productcategory_id')->references('id')->on('productcategories')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')
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
        Schema::dropIfExists('products');
    }
}
