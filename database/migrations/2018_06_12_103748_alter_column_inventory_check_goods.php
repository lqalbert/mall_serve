<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnInventoryCheckGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_check_goods', function (Blueprint $table) {
            $table->string('cate_type_id')->nullable()->change();
            $table->string('cate_kind_id')->nullable()->change();
            $table->string('cate_type')->nullable()->change();
            $table->string('cate_kind')->nullable()->change();
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
            $table->dropColumn(['cate_type_id','cate_kind_id','cate_type','cate_kind']);
        });
    }
}
