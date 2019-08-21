<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffattendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffattendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('staff_id')->unsigned()->nullable();
            $table->integer('store_id')->unsigned()->nullable();
            $table->string('date');
            $table->integer('type')->default(0);
            $table->timestamps();

            $table->foreign('staff_id')->references('id')->on('staff')
                    ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('staffattendances');
    }
}
