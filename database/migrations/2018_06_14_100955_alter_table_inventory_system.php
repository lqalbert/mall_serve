<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableInventorySystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_system', function (Blueprint $table) {
            $table->unsignedInteger('sale_count')->default(0)->comment('累计销售');
            $table->unsignedInteger('produce_out')->default(0)->comment('累计生产出库');
            $table->unsignedInteger('check_in')->default(0)->comment('累计盘点入库');
            $table->unsignedInteger('check_out')->default(0)->comment('累计盘点出库');
            $table->unsignedInteger('return_in')->default(0)->comment('退货入库');
            $table->unsignedInteger('return_out')->default(0)->comment('退货出库');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_system', function (Blueprint $table) {
            $table->dropColumn(['sale_count', 'produce_out', 'check_in', 'check_out', 'return_in', 'return_out']);
        });
    }
}
