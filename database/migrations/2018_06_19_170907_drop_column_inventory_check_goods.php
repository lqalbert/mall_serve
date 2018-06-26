<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnInventoryCheckGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_check_goods', function (Blueprint $table) {
            $table->dropColumn(['entrepot_id', 'entrepot_name', 'check_num']);
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
            //
        });
    }
}
