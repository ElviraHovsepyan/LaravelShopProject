<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcatProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcat_product', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('product_id')->default(1);
            $table->foreign('product_id')->references('id')->on('products');

            $table->unsignedInteger('subcat_id')->default(1);
            $table->foreign('subcat_id')->references('id')->on('subcat');

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
        Schema::dropIfExists('subcat_product');
    }
}
