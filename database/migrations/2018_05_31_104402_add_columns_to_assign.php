<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToAssign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assign_basic', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_repeat')->default(0)->comment('是否返单 1导入状态 2审核状态 3录入状态');
            $table->unsignedTinyInteger('is_stop')->default(0)->comment('是否拦截');
            $table->string('repeat_mark', 200)->nullable()->comment('返单备注');
            $table->string('stop_mark', 200)->nullable()->comment('拦截备注');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assign_basic', function (Blueprint $table) {
            $table->dropColumn(["is_repeat","is_stop","repeat_mark","stop_mark"]);
        });
    }
}
