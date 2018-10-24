<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJdOrderOther extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jd_order_other', function (Blueprint $table) {
            $table->increments('id');
            $table->char("order_sn",16)->nullable()->comment('订单号');
            $table->string("invoice_type")->nullable()->comment('发票类型');
            $table->string("invoice_head")->nullable()->comment('发票抬头');
            $table->string("invoice_content")->nullable()->comment('发票内容');
            $table->string("shop_remark")->nullable()->comment('商家备注');
            $table->string("shop_remark_level")->nullable()->comment('商家备注等级(等级1-5为由高到低)');
            $table->string("add_tax_invoice")->nullable()->comment('增值税发票');
            $table->string("general_invoice_tax")->nullable()->comment('普通发票纳税编号');
            $table->string("shop_sku_id")->nullable()->comment('商家SKUID ');
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
        Schema::dropIfExists('jd_order_other');
    }
}
