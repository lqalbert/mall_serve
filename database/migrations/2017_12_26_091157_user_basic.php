<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_basic', function (Blueprint $table) {
            $table->increments('id')->comment('员工ID');
            $table->string('account', 20)->unique()->comment('员工登陆账号');
            $table->string('realname', 20)->comment('员工姓名');
            $table->string('department_name', 20)->comment('员工所在部门');
            $table->string('group_name', 20)->comment('员工所在团队');
            $table->string('head', 256)->default('/storage/9P8Y8NKQfWRGt26rkTm9eO4Kv5e08LnZJSvsHbzb.jpeg')->comment('员工头像');
            $table->string('password')->comment('登陆密码');
            $table->unsignedInteger('qq')->comment('员工QQ号');
            $table->string('qq_nickname', 40)->comment('员工QQ昵称');
            $table->unsignedInteger('role_id')->comment('员工职位ID');
            $table->string('role_name', 40)->comment('员工职位名称');
            $table->unsignedTinyInteger('sex')->default(0)->comment('0 未定义 1 男 2 女');
            $table->string('phone',20)->comment('员工固话');
            $table->string('phone_number',20)->comment('员工手机号');
            $table->string('id_card',20)->comment('员工身份证号');
            $table->string('weixin',20)->comment('员工微信号');
            $table->string('weixin_nickname',20)->comment('员工微信昵称');
            $table->string('address',256)->comment('员工住址');
            $table->string('location',256)->comment('登陆地点');
            $table->ipAddress('ip')->comment('登陆IP');
            $table->string('create_name', 20)->comment('创建员工');
            $table->dateTime('lg_time')->comment('最后登陆时间');
            $table->dateTime('out_time')->comment('最后退出时间');
            $table->unsignedInteger('department_id')->default(0)->comment('员工所在部门ID');
            $table->unsignedInteger('group_id')->default(0)->comment('员工所在团队ID');

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
        Schema::dropIfExists('user_basic');
    }
}
