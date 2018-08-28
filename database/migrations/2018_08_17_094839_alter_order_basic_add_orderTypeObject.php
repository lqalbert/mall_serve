<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderBasicAddOrderTypeObject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_basic', function (Blueprint $table) {
            $table->text('type_object')->nullable()->comment('订单类型plan Object 简单对象');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_basic', function (Blueprint $table) {
            $table->drop('type_object');
        });
    }
}
