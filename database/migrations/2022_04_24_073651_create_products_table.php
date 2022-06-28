<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by');
            $table->string('product_image');
            $table->string('name');
            $table->string('sku')->unique();
            $table->float('price');
            $table->boolean('stock_item')->default(true);
            $table->bigInteger('stock')->default(0);
            $table->bigInteger('branch');
            $table->bigInteger('category');
            $table->boolean('show_on_website')->nullable()->default(true);
            $table->boolean('featured')->nullable()->default(false);
            $table->bigInteger('sale_count')->default(0);
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
        Schema::dropIfExists('products');
    }
}
