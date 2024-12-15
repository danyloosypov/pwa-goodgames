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

			Schema::table("teammates_{$lang->tag}", function (Blueprint $table) {
			$table->unsignedBigInteger("id_teams");
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
			
			Schema::table("teammates_{$lang->tag}", function (Blueprint $table) {
			
			});
		}
    }
};
