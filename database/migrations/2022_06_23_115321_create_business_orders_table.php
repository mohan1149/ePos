<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by');
            $table->bigInteger('branch');
            $table->bigInteger('driver');
            $table->longText('items')->nullable();
            $table->bigInteger('client')->nullable();
            $table->integer('payment_status')->unsigned()->nullable()->default(0);
            $table->integer('payment_method')->unsigned()->nullable()->default(0);
            $table->float('order_total')->nullable();
            $table->float('final_total')->nullable();
            $table->float('discount')->nullable();
            $table->float('total_paid')->nullable();
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
        Schema::dropIfExists('business_orders');
    }
}
