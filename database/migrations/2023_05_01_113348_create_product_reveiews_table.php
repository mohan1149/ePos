<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReveiewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reveiews', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('product_id');
            $table->longText('comments')->nullable();
            $table->float('rating')->default(1.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_reveiews');
    }
}
