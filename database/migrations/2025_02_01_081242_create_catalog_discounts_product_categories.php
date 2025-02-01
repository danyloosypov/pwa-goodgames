<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_discounts_product_categories', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger("id_catalog_discounts");
			$table->unsignedBigInteger("id_product_categories");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_discounts_product_categories');
    }
};
