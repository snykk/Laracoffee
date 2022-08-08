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
            $table->integer("product_id");
            $table->integer("user_id");
            $table->integer("quantity");
            $table->string("address");
            $table->string("shipping_address");
            $table->integer("total_price");
            $table->integer("payment_id");
            $table->integer("bank_id")->nullable();
            $table->integer("note_id");
            $table->integer("status_id");
            $table->string("transaction_doc")->nullable();
            $table->integer("is_done");
            $table->string("refusal_reason")->nullable();
            $table->integer("coupon_used");
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
        Schema::dropIfExists('orders');
    }
};
