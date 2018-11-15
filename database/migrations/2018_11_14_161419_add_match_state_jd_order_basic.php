<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMatchStateJdOrderBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jd_order_basic', function (Blueprint $table) {
            $table->unsignedTinyInteger('match_state')->default(0)->comment('0 未匹配 1已匹配 2匹配失败');
            
            $table->string('express_name',20)->nullable()->comment('快递公司');
            $table->string('express_sn', 50)->nullable()->comment('快递号');
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
            $table->dropColumn(['match_state','express_sn','expres_name']);
        });
    }
}
