<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsSlideUploadPicture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slide_upload_picture', function (Blueprint $table) {
            $table->string('href_url',50)->nullable()->after('classify')->comment('跳转链接');
            $table->string('description',50)->nullable()->after('href_url')->comment('图片描述');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slide_upload_picture', function (Blueprint $table) {
            $table->dropColumn(['href_url','description']);
        });
    }
}
