<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableInvoiceOperationRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_operation_records', function (Blueprint $table) {
            $table->dropColumn(['user_id','user_name','op_time','remark']);
        });

        Schema::table('invoice_operation_records', function (Blueprint $table) {
            $table->unsignedInteger('operator_id')->after('assign_id')->comment('操作员ID');
            $table->string('operator',20)->nullable()->after('operator_id')->comment('操作员姓名');
            $table->string('action',20)->nullable()->after('operator')->comment('操作动作');
            $table->string('remark')->nullable()->after('action')->comment('操作备注');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_operation_records', function (Blueprint $table) {
            $table->dropColumn(['operator_id','operator','action','remark']);
        });
    }
}
