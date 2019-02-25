<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalCareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_care', function (Blueprint $table) {
            $table->increments('id');
            $table->string('plan_num',32)->unique()->comment('方案编号');
            $table->unsignedInteger('user_id')->comment('方案所属用户');
            $table->string('user_name',32)->comment('用户姓名');
            $table->string('user_sex',4)->comment('用户性别');
            $table->string('diagnosis',255)->comment('问题诊断');
            $table->string('deal_plan',255)->comment('解决方案');
            $table->string('sign',255)->comment('导师签名');
            $table->string('introduction',255)->comment('使用说明');
            $table->string('organization',32)->comment('护肤机构');
            $table->text('show')->comment('护肤方案展示');
            $table->string('sum',32)->comment('总价');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_care');
    }
}
