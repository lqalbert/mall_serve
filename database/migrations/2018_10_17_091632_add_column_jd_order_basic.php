<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnJdOrderBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jd_order_basic', function (Blueprint $table) {
            $table->unsignedInteger("department_id")->nullable()->after('order_sn')->comment('部门id');
            $table->unsignedInteger("group_id")->nullable()->after('department_id')->comment('小组id');
            $table->unsignedInteger("user_id")->nullable()->after('group_id')->comment('员工id');
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
            $table->dropColumn(["department_id","group_id","user_id"]);
        });
    }
}
