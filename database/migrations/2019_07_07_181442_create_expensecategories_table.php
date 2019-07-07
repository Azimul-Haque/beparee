<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensecategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expensecategories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_id')->unsigned()->nullable(); // type 0 will be null
            $table->integer('type')->unsigned()->nullable(); // 0 for common, 1 for specific store 
            $table->string('name');

            $table->foreign('store_id')->references('id')->on('stores')
                ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('expensecategories');
    }
}
