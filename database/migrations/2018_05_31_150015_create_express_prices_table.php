<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpressPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('express_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('express_id')->nullable()->comment('快递公司ID');
            $table->string('express_name',20)->nullable()->comment('快递公司名称');

            $table->unsignedInteger('area_province_id')->nullable()->comment('省ID');
            $table->string('area_province_name',20)->nullable()->comment('省名称');

            $table->unsignedInteger('area_city_id')->nullable()->comment('市ID');
            $table->string('area_city_name',20)->nullable()->comment('市名称');

            $table->unsignedInteger('area_district_id')->nullable()->comment('区/县ID');
            $table->string('area_district_name',20)->nullable()->comment('区/县名称');

            $table->unsignedInteger('time_limit')->nullable()->comment('时效（天）');
            $table->unsignedInteger('first_weight')->nullable()->comment('首重');
            $table->unsignedInteger('first_price')->nullable()->comment('首价');
            $table->unsignedInteger('continued_weight')->nullable()->comment('续重');
            $table->unsignedInteger('continued_price')->nullable()->comment('续价');


            $table->string('start_time',20)->nullable()->comment('开始时间');
            $table->string('end_time',20)->nullable()->comment('结束事件');
            $table->string('is_use',2)->nullable()->comment('是否启用');
            $table->string('remark',200)->nullable()->comment('备注');
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
        Schema::dropIfExists('express_prices');
    }
}
