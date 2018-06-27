<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnActualDeliveryGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actual_delivery_goods', function (Blueprint $table) {
            $table->unsignedTinyInteger('sign_status')->default(0)->comment('订单签收状态 0 未签收 1 签收');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actual_delivery_goods', function (Blueprint $table) {
            $table->dropColumn(['sign_status']);
        });
    }
}
