<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntrepotIdJdOrderBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jd_order_basic', function (Blueprint $table) {
            $table->unsignedInteger('entrepot_id')->default(0)->comment('配送中心');
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
            $table->dropColumn('entrepot_id');
        });
    }
}
