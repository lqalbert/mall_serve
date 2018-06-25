<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInventoryDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_detail', function (Blueprint $table) {
            $table->integer('stock_in')->nullable()->comment('盘点入库');
            $table->integer('stock_out')->nullable()->comment('盘点出库');
            $table->string('dan_sn')->nullable()->comment('单号');
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
            $table->dropColumn(['stock_in','stock_out','dan_sn']);
        });
    }
}
