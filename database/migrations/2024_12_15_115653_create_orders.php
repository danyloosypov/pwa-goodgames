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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
			$table->string("name");
			$table->string("email");
			$table->string("subtotal");
			$table->string("total");
			$table->tinyInteger("is_paid");
			$table->dateTime("date")->default("2000-01-01 00:00:00"); // some DBs have errors with the default 0000-00-00 00:00:00
			$table->unsignedBigInteger("id_order_statuses");
			$table->unsignedBigInteger("id_users");
			$table->unsignedBigInteger("id_payments");
			$table->text("comment");
			$table->string("stripe_session_id");
			$table->string("liqpay_id");
			$table->string("paypal_id");
			$table->string("coingate_id");
			$table->string("nowpayments_id");
			$table->unsignedBigInteger("id_promocodes");
			$table->integer("points_used");
			$table->decimal("promocode_price", 15, 2);
			$table->decimal("discount_price", 15, 2);
			$table->string("fondy_payment_id");
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
        Schema::dropIfExists('orders');
    }
};
