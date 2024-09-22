<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportExportProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_export_product', function (Blueprint $table) {
            $table->id();
            $table->integer('product_attributes_id');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('survive_sl');
            $table->integer('survive_tt');
            $table->integer('import_sl');
            $table->integer('import_tt');
            $table->integer('export_sl');
            $table->integer('export_tt');
            $table->integer('ending_sl');
            $table->integer('ending_tt');
            $table->integer('type');
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
        Schema::dropIfExists('import_export_product');
    }
}
