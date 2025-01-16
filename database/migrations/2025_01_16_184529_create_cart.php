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
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger("id_users");
			$table->unsignedBigInteger("id_products");
			$table->integer("qty");
			$table->text("meta");
			$table->timestamp("created_at")->default(\DB::raw("CURRENT_TIMESTAMP"));
			$table->timestamp("updated_at")->default(\DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart');
    }
};
