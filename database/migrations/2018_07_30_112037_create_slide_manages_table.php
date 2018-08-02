<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlideManagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide_manages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('classify')->nullable()->comment('图片展示位置 1 顶部循环 2 重磅新品 3 口碑之选 4 中间展示 5 图文结合 6 底部展示');
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
        Schema::dropIfExists('slide_manages');
    }
}
