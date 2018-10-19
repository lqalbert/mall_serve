<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnJdMatchBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jd_match_basic', function (Blueprint $table) {
            $table->increments('id');
            $table->string('flag',15)->nullable()->comment('批次标识');
            $table->unsignedInteger('sum')->nullable()->comment('导入数目');
            $table->string('file_name')->nullable()->comment('文件名称');
            $table->unsignedTinyInteger('match_status')->default(0)->comment('匹配状态0未 1匹配中 2完成');
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
        Schema::dropIfExists('jd_match_basic');
    }
}
