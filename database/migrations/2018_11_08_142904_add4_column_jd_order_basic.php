<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add4ColumnJdOrderBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jd_order_basic', function (Blueprint $table) {
            $table->unsignedInteger("cus_id")->nullable()->after('user_id')->comment('客户id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jd_order_basic', function (Blueprint $table) {
            $table->dropColumn(['cus_id']);
        });
    }
}
