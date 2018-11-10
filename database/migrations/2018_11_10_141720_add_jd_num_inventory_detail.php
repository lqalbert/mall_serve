<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJdNumInventoryDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_detail', function (Blueprint $table) {
            $table->smallInteger('jd_num')->nullable()->comment('京东的订单 正数表示减库存 负数表示加库存');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_detail', function (Blueprint $table) {
           $table->dropColumn('jd_num');
        });
    }
}
