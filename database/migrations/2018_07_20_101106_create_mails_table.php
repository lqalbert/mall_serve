<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->nullable()->comment('收件人姓名');
            $table->string('phone',20)->nullable()->comment('收件人手机号');
            $table->unsignedInteger('express_id')->nullable()->comment('快递公司ID');
            $table->string('express_name',20)->nullable()->comment('快递名称');
            $table->string('express_sn',20)->nullable()->comment('快递单号');
            $table->unsignedInteger('area_province_id')->nullable()->comment('省ID');
            $table->unsignedInteger('area_city_id')->nullable()->comment('市ID');
            $table->unsignedInteger('area_district_id')->nullable()->comment('区县ID');
            $table->string('area_province_name',20)->nullable()->comment('省名称');
            $table->string('area_city_name',20)->nullable()->comment('市名称');
            $table->string('area_district_name',20)->nullable()->comment('区县名称');
            $table->string('address',100)->nullable()->comment('详细地址');
            $table->string('remark',100)->nullable()->comment('备注');
            $table->string('type',2)->nullable()->default(1)->comment('类型 1 自行寄件 2 拆分寄件');
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
        Schema::dropIfExists('mails');
    }
}
