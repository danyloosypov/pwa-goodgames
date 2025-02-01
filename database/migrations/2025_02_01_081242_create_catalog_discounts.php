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
        Schema::create('catalog_discounts', function (Blueprint $table) {
            $table->id();
			$table->string("title");
			$table->integer("value");
			$table->string("symbol");
			$table->tinyInteger("is_active");
			$table->dateTime("date_start")->default("2000-01-01 00:00:00"); // some DBs have errors with the default 0000-00-00 00:00:00
			$table->dateTime("date_end")->default("2000-01-01 00:00:00"); // some DBs have errors with the default 0000-00-00 00:00:00
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
        Schema::dropIfExists('catalog_discounts');
    }
};
