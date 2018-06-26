<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColummInventoryCheckGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_check_goods', function (Blueprint $table) {
            $table->unsignedInteger('cate_type_id')->change();
            $table->unsignedInteger('cate_kind_id')->change();
            $table->unsignedDecimal('goods_price')->change();
            $table->unsignedDecimal('profit_money')->change();
            $table->unsignedDecimal('loss_money')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_check_goods', function (Blueprint $table) {
            $table->dropColumn(['cate_type_id','cate_kind_id','goods_price','profit_money','loss_money']);
        });
    }
}
