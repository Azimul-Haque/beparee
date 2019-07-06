<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDuehistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duehistories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vendor_id')->unsigned();
            $table->integer('transaction_type')->unsigned();
            $table->string('amount');
            $table->string('remark')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('duehistories');
    }
}
