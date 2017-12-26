<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_basic', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account', 20)->unique();
            $table->string('password');
            $table->string('head', 256)->default('/storage/9P8Y8NKQfWRGt26rkTm9eO4Kv5e08LnZJSvsHbzb.jpeg');
            $table->unsignedInteger('department_id')->default(0);
            $table->unsignedInteger('group_id')->default(0);
            $table->string('realname', 20);
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
