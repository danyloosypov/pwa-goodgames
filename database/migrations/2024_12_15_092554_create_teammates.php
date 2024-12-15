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

			Schema::create("teammates_{$lang->tag}", function (Blueprint $table) {
			$table->id();
			$table->string("nickname");
			$table->string("slug");
			$table->string("real_name");
			$table->string("photo");
			$table->string("kda_ration_num");
			$table->string("kda_ration_text");
			$table->string("cs_per_min_num");
			$table->string("cs_per_min_text");
			$table->string("kill_participation_num");
			$table->string("kill_participation_text");
			$table->text("biography");
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

        	Schema::dropIfExists("teammates_{$lang->tag}");
		}
    }
};
