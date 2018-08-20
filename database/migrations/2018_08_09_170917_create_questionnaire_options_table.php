<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnaireOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_options', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('questionnaire_managements_id')->nullable()->comment('问卷表ID');
            $table->unsignedInteger('problem_type')->nullable()->comment('题目类型 1 单项选择型 2 多项选择型 3 文字填写型');
            $table->string('topic_name',100)->nullable()->comment('问卷题目');
            $table->string('option_a',100)->nullable()->comment('选项A');
            $table->string('option_b',100)->nullable()->comment('选项B');
            $table->string('option_c',100)->nullable()->comment('选项C');
            $table->string('option_d',100)->nullable()->comment('选项D');
            $table->string('option_e',100)->nullable()->comment('选项E');
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
        Schema::dropIfExists('questionnaire_options');
    }
}
