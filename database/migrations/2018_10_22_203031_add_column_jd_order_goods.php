<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnJdOrderGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jd_order_goods', function (Blueprint $table) {
            $table->string('flag',15)->nullable()->after('entrepot_name')->comment('批次标识');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jd_order_goods', function (Blueprint $table) {
            $table->dropColumn(['order_account']);
        });
    }
}
