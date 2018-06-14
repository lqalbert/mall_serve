<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddColumnsOrderGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_goods', function (Blueprint $table) {
            $table->dropColumn('exchange_status');
            
            $table->string('reason',30)->nullable()->comment('退货原因');
            $table->unsignedTinyInteger('status')->default(0)->comment('0 正常　1 退货 2 换货 3 换货重发');
            $table->unsignedTinyInteger('inventory')->nullable()->comment('0入库　1出库');
            $table->unsignedMediumInteger('return_num')->default(0)->comment('退货数量');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_goods', function (Blueprint $table) {
            $table->string('exchange_status')->nullable();
            
            $table->dropColumn(['reason', 'status', 'inventory', 'return_num']);
        });
    }
}
