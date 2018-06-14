<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewTableInventoryCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_check', function (Blueprint $table) {
            $table->increments('id');
            $table->string('check_num',15)->nullable()->comment('盘点单号');
            $table->string('check_name',50)->nullable()->comment('盘点人');
            $table->unsignedInteger('check_user_id')->nullable()->comment('盘点人ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_check');
    }
}
