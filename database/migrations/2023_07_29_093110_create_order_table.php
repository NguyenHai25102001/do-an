<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('vocative');
            $table->string('delivery_address');
            $table->integer('province_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('ward_id')->nullable();
            $table->string('address_detail')->nullable();
            $table->string('full_address')->nullable();
            $table->string('note');
            $table->integer('issue_invoice')->default(0);
            $table->string('name_cty')->nullable();
            $table->string('address_cty')->nullable();
            $table->string('tax_code')->nullable();
            $table->integer('type_payment');
            $table->string('transport_name')->nullable();
            $table->string('order_code_transport')->nullable();
            $table->integer('fee_shipping')->default(0);
            $table->bigInteger('total_money_product');
            $table->bigInteger('total_money_order');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('order');
    }
}
