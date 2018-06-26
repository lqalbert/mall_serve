<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInventoryCheckGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_check_goods', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_fixed')->default(0)->comment('是否修改过库存');
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
            $table->dropColumn(['is_fixed']);
        });
    }
}
