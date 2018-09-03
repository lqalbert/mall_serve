<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderAfterAddReason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_after', function (Blueprint $table) {
            $table->string('reason')->nullable()->comment('退货原因');
            $table->string('check_mark')->nullable()->comment('审核备注');
            $table->unsignedTinyInteger('in_inventory')->default(0)->comment('入库操作 0未 1已');
            $table->unsignedTinyInteger('out_inventory')->default(0)->comment('出库操作损坏出库 0未 1已');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_after', function (Blueprint $table) {
            $table->dropColumn(['reason','check_mark','in_inventory', 'out_inventory']);
        });
    }
}
