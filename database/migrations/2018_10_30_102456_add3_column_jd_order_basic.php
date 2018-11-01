<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add3ColumnJdOrderBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jd_order_basic', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_brusher')->default(0)->after('flag')->comment('是否刷单 0否1是');
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
            $table->dropColumn(['is_brusher']);
        });
    }
}
