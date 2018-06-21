<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnInventoryCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_check', function (Blueprint $table) {
            $table->dropColumn('check_num');
            $table->char('check_sn',16)->nullable()->comment('盘点单号')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_check', function (Blueprint $table) {
            $table->dropColumn('check_sn');
        });
    }
}
