<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEfficacyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('efficacy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('plan_id',32)->unique()->comment('方案编号');
            $table->string('name',128)->comment('方案名称');
            $table->string('key_words',255)->comment('关键词');
            $table->string('situation',255)->comment('适用情况');
            $table->string('suggestion',255)->comment('搭配建议');
            $table->unsignedInteger('creator_id')->comment('创建人ID');
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
        Schema::dropIfExists('efficacy');
    }
}
