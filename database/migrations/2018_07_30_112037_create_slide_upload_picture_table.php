<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlideUploadPictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide_upload_picture', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('goods_id')->nullable()->comment('商品ID');
            $table->string('name',30)->nullable()->comment('图片名称');
//            $table->string('type',30)->nullable()->comment('上传文件类型');
//            $table->string('size',10)->nullable()->comment('上传文件大小');
//            $table->string('file_name', 50)->nullable()->comment('原文件名');
//            $table->string('path',50)->nullable()->comment('文件路径');
            $table->string('cover_url',100)->nullable()->comment('文件url');
            $table->unsignedInteger('picture_sort')->nullable()->comment('图片排序');
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
        Schema::dropIfExists('slide_upload_picture');
    }
}
