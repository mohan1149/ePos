<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutSideOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('out_side_orders', function (Blueprint $table) {
            $table->id();
            $table->string('track_id');
            $table->bigInteger('created_for');
            $table->bigInteger('branch');
            $table->longText('order_items')->nullable();
            $table->float('total');
            $table->string('cust_name')->nullable();
            $table->string('cust_phone')->nullable();
            $table->string('cust_email')->nullable();
            $table->string('cust_state')->nullable();
            $table->string('cust_city')->nullable();
            $table->string('cust_area')->nullable();
            $table->string('cust_block')->nullable();
            $table->string('cust_avenue')->nullable();
            $table->string('cust_street')->nullable();
            $table->string('cust_house_apartment')->nullable();
            $table->string('cust_landmark')->nullable();
            $table->integer('status')->unsigned()->nullable()->default(0);
            $table->boolean('payment_status')->nullable()->default(false);
            $table->bigInteger('handler')->nullable();
            $table->bigInteger('driver')->nullable();
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
        Schema::dropIfExists('out_side_orders');
    }
}
