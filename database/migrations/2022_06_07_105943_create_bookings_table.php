<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by');
            $table->bigInteger('booked_by');
            $table->bigInteger('branch')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('number_of_people')->nullable();
            $table->dateTime('booking_datetime')->nullable();
            $table->bigInteger('staff')->nullable();
            $table->bigInteger('category')->nullable();
            $table->text('services')->nullable();
            $table->integer('status')->unsigned()->default(0);
            $table->mediumText('notes')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
