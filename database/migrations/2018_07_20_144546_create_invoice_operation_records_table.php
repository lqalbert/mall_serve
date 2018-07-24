<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceOperationRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_operation_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('assign_id')->nullable()->comment('发货单ID');
            $table->unsignedInteger('user_id')->nullable()->comment('操作人ID');
            $table->string('user_name',20)->nullable()->comment('操作人');
            $table->string('op_time',20)->nullable()->comment('操作时间');
            $table->string('remark',100)->nullable()->comment('备注');
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
        Schema::dropIfExists('invoice_operation_records');
    }
}
