<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnaireSurveyResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_survey_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cus_id')->nullable()->comment('客户ID');
            $table->unsignedInteger('questionnaire_managements_id')->nullable()->comment('问卷表ID');
            $table->unsignedInteger('questionnaire_options_id')->nullable()->comment('题目ID');
            $table->unsignedInteger('answer_a')->nullable()->default(0)->comment('选择A答案');
            $table->unsignedInteger('answer_b')->nullable()->default(0)->comment('选择B答案');
            $table->unsignedInteger('answer_c')->nullable()->default(0)->comment('选择C答案');
            $table->unsignedInteger('answer_d')->nullable()->default(0)->comment('选择D答案');
            $table->unsignedInteger('answer_e')->nullable()->default(0)->comment('选择E答案');
            $table->string('answer',200)->nullable()->comment('填空题客户回答');
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
        Schema::dropIfExists('questionnaire_survey_results');
    }
}
