<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\FastAdminPanel\Models\Language;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		$languages = Language::get();

		foreach ($languages as $lang) {

			Schema::create("products_{$lang->tag}", function (Blueprint $table) {
			$table->id();
			$table->string("title");
			$table->string("slug");
			$table->decimal("price", 15, 2);
			$table->decimal("old_price", 15, 2);
			$table->string("sku");
			$table->text("excerpt");
			$table->date("release_date")->default("2000-01-01"); // some DBs have errors with the default 0000-00-00
			$table->string("pegi_rating");
			$table->string("image");
			$table->text("gallery");
			$table->string("installer");
			$table->tinyInteger("is_active");
			$table->text("meta_title");
			$table->text("meta_description");
			$table->text("meta_keywords");
			$table->timestamp("created_at")->default(\DB::raw("CURRENT_TIMESTAMP"));
			$table->timestamp("updated_at")->default(\DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"));
			});
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		$languages = Language::get();

		foreach ($languages as $lang) {

        	Schema::dropIfExists("products_{$lang->tag}");
		}
    }
};
