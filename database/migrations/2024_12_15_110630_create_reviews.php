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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger("id_users");
			$table->integer("rating");
			$table->date("date")->default("2000-01-01"); // some DBs have errors with the default 0000-00-00
			$table->text("text");
			$table->unsignedBigInteger("id_products");
			$table->unsignedBigInteger("id_articles");
			$table->unsignedBigInteger("id_reviews");
			$table->text("admin_reply");
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
        Schema::dropIfExists('reviews');
    }
};
