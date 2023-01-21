<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id');   
            $table->string('customer_state')->nullable();
            $table->string('customer_city')->nullable();
            $table->string('customer_area')->nullable();
            $table->string('customer_avenue')->nullable();
            $table->string('customer_block')->nullable();
            $table->string('customer_street')->nullable();
            $table->string('customer_house_apartment')->nullable();
            $table->string('customer_landmark')->nullable();
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
        Schema::dropIfExists('customer_addresses');
    }
}
