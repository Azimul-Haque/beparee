<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_id')->unsigned();
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('nid')->nullable();
            $table->string('total_purchase')->default('0'); // means total sales to customer
            $table->string('current_due')->default('0.00');
            $table->string('total_due')->default('0.00');
            $table->string('total_due_paid')->default('0.00');
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores')
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
        Schema::dropIfExists('customers');
    }
}
