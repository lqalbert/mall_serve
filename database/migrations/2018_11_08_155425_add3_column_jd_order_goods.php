<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add3ColumnJdOrderGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jd_order_goods', function (Blueprint $table) {
            $table->unsignedTinyInteger("is_minus")->default(0)
                ->after('entrepot_id')->comment('扣除库存0未1成功2失败');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jd_order_goods', function (Blueprint $table) {
            $table->dropColumn(['is_minus']);
        });
    }
}
