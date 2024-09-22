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
            $table->integer('product_infor_id');
            $table->string('name');
            $table->string('slug');
            $table->integer('price')->default(0);
            $table->integer('promotional_price')->default(0);
            $table->integer('quantity')->default(0);
            $table->string('own_parameter');
            $table->longText('specifications');
            $table->integer('is_featured_products')->default(0);
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
