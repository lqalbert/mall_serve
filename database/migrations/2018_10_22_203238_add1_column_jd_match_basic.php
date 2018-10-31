<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add1ColumnJdMatchBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jd_match_basic', function (Blueprint $table) {
            $table->unsignedTinyInteger('inventory_status')->default(0)->after('match_status')->comment('扣除库存0未 1扣除中 2扣除完成');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jd_match_basic', function (Blueprint $table) {
            $table->dropColumn(['inventory_status']);
        });
    }
}
