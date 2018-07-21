<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreightTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freight_template', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string("name",20)->default("")->comment('模板名称');
            $table->string("express",20)->default("")->comment("快递公司名");
            $table->unsignedInteger("entrepot_id")->comment('配送中收');
            $table->unsignedTinyInteger('is_unify')->default(0)->comment('是否统一运费 0否 1是');
            $table->decimal('unify_fee')->default('0.00')->comment('统一运费 ');
            $table->unsignedTinyInteger('is_include')->default(0)->comment('是否支持包邮 0 不包 1包');
            $table->decimal('stand_fee')->default('0.00')->comment('包邮 条件 满多少才包 单位元');
            $table->decimal('stand_extra')->default('0.00')->comment('包邮 额外的费用 例如 顺丰 要加12元');
            $table->decimal('basic_fee')->default('0.00')->comment('不包邮的 基本邮费 物殊地区的邮费在另一个表里');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freight_template');
    }
}
