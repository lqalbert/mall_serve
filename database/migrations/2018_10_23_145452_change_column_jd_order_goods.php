<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnJdOrderGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jd_order_goods', function (Blueprint $table) {
            $table->renameColumn('entrepot_id', 'jd_entrepot_id');
            $table->renameColumn('entrepot_name', 'jd_entrepot_name');
        });
        Schema::table('jd_order_goods', function (Blueprint $table) {
            $table->unsignedInteger('entrepot_id')->nullable()->after('flag')->comment('配送中心');
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
            $table->dropColumn(['jd_entrepot_id','jd_entrepot_name','entrepot_id']);
        });
    }
}
