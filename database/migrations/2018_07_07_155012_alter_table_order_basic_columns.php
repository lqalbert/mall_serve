<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableOrderBasicColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_basic', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->comment('客户所属员工id');
            $table->string('user_name', 20)->nullable()->comment('客户所属员工名称');
            $table->string('group_name',20)->nullable()->comment('客户所属员工小组名称');
            $table->string('department_name',20)->nullable()->comment('客户所属员工部门名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_basic', function (Blueprint $table) {
            $table->dropColumn(['user_id','user_name','group_name','department_name']);
        });
    }
}
