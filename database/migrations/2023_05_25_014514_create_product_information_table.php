<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_information', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->integer('category_id')->nullable();
            $table->string('name_category')->nullable();
            $table->string('parameter_one')->nullable();
            $table->string('parameter_two')->nullable();
            $table->string('parameter_three')->nullable();
            $table->string('parameter_four')->nullable();
            $table->longText('product_information')->nullable();
            $table->longText('special_offer')->nullable();
            $table->longText('promotion_policy')->nullable();
            $table->longText('salient_features')->nullable();
            $table->integer('type_product')->default(1);
            $table->integer('display')->default(1);
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
        Schema::dropIfExists('product_information');
    }
}
