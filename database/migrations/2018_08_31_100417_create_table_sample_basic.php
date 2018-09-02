<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSampleBasic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_basic', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('check_status')->default(0)->comment('审核状态 1通过 2未通过');
            $table->string('applicant',50)->nullable()->comment('申请人');
            $table->string('operator',50)->nullable()->comment('操作人');
            $table->string('use_remark')->nullable()->comment('用途备注');
            $table->string('check_remark')->nullable()->comment('审核备注');
            $table->date('app_time')->nullable()->comment('申请时间');
            $table->dateTime('check_time')->nullable()->comment('审核时间');
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
        Schema::dropIfExists('sample_basic');
    }
}
