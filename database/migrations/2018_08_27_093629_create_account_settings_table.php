<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('department_id')->nullable()->comment('部门ID');
            $table->unsignedInteger('group_id')->nullable()->comment('小组ID');
            $table->unsignedInteger('user_id')->nullable()->comment('员工ID');
            $table->string('department_name',20)->nullable()->comment('部门名称');
            $table->string('group_name',20)->nullable()->comment('小组名称');
            $table->string('user_name',20)->nullable()->comment('员工姓名');
            $table->unsignedInteger('now_number')->nullable()->default(0)->comment('小组现有客户数');
            $table->unsignedInteger('max_number')->nullable()->default(0)->comment('小组最大接纳客户数');
            $table->unsignedInteger('status')->nullable()->default(0)->comment('启用状态');
            $table->string('remark',100)->nullable()->comment('备注');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_settings');
    }
}
