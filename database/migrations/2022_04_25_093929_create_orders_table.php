<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('tsid');
            $table->string('order_for')->nullable();
            $table->bigInteger('branch');
            $table->bigInteger('staff');
            $table->longText('order_items')->nullable();
            $table->bigInteger('created_for');
            $table->float('total');
            $table->float('discount')->nullable()->default(0);
            $table->float('discount_amount')->nullable()->default(0);
            $table->float('final_total');
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
        Schema::dropIfExists('orders');
    }
}
