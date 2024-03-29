<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->date('date');
            $table->string('status');
            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->text('address');
            $table->integer('phone');
            $table->integer('postal_code');
            $table->date('deliviry_date');
            $table->decimal('price', 8,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
