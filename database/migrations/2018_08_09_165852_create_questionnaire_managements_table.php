<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnaireManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_managements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100)->unllable()->comment('标题');
            $table->string('start_time',20)->unllable()->comment('发布时间');
            $table->string('end_time',20)->unllable()->comment('截止时间');
            $table->unsignedInteger('user_id')->unllable()->comment('发布人ID');
            $table->string('user_name',20)->unllable()->comment('发布人');
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
        Schema::dropIfExists('questionnaire_managements');
    }
}
