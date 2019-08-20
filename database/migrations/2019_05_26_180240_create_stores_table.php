<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token')->unique();
            $table->string('code')->unique();
            $table->string('name');
            $table->integer('established');
            $table->text('address');
            $table->string('upazilla');
            $table->string('district');
            $table->integer('activation_status');
            $table->integer('payment_status');
            $table->integer('payment_method');
            $table->integer('smsbalance')->default('0');
            $table->string('smsrate')->default('0.35');
            $table->string('monogram')->nullable();
            $table->string('slogan')->nullable();
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
        Schema::dropIfExists('stores');
    }
}
