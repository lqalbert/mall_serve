<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderAfter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_after', function (Blueprint $table) {
            $table->unsignedTinyInteger('inventory_state')->default(0)->comment('库存操作 必须要确认后才可以 1已操 0未操作');
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
            $table->dropColumn(['inventory_state']);
        });
    }
}
