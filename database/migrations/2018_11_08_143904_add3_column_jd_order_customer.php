<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add3ColumnJdOrderCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jd_order_customer', function (Blueprint $table) {
            $table->unsignedInteger("cus_id")->nullable()->after('order_sn')->comment('客户id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jd_order_customer', function (Blueprint $table) {
            $table->dropColumn(['cus_id']);
        });
    }
}
