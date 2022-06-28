<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by');
            $table->integer('decimal_points')->nullable()->default(3);
            $table->boolean('enable_bookings')->nullable()->default(false);
            $table->boolean('enable_home_service')->nullable()->default(false);
            $table->boolean('enable_home_delivery')->nullable()->default(false);
            $table->boolean('enable_website')->nullable()->default(false);
            $table->boolean('enable_device_linking')->nullable()->default(false);
            $table->boolean('show_out_of_stock_products')->nullable()->default(false);
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
        Schema::dropIfExists('settings');
    }
}
