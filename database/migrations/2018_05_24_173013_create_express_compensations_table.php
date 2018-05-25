<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpressCompensationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('express_compensations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('entrepot_id')->nullable()->comment('配送中心ID');
            $table->string('entrepot_name')->nullable()->comment('配送中心名称');
            $table->unsignedInteger('express_id')->nullable()->comment('物流公司ID');
            $table->string('express_name',20)->nullable()->comment('物流公司名称');
            $table->string('deliver_time',20)->nullable()->comment('发货时间');
            $table->string('order_number',20)->nullable()->comment('订单编号');
            $table->string('express_number',20)->nullable()->comment('快递单号');
            $table->string('compensation_type',20)->nullable()->comment('赔偿类型');
            $table->string('compensation_money',20)->nullable()->comment('赔偿金额');
            $table->string('processing_progress',20)->nullable()->comment('处理进度');
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
        Schema::dropIfExists('express_compensations');
    }
}
