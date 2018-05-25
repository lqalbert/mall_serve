<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToOrderAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_address', function (Blueprint $table) {
            $table->unsignedInteger('area_province_id')->nullable()->comment('省id')->after('default_address');
            $table->unsignedInteger('area_city_id')->nullable()->comment('市id')->after('area_province_id');
            $table->unsignedInteger('area_district_id')->nullable()->comment('区/县id')->after('area_city_id');
            $table->string('area_province_name',20)->nullable()->comment('省name')->after('area_district_id');
            $table->string('area_city_name',20)->nullable()->comment('市name')->after('area_province_name');
            $table->string('area_district_name',20)->nullable()->comment('区/县name')->after('area_city_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_address', function (Blueprint $table) {
            $table->dropColumn([
                'area_province_id',
                'area_city_id',
                'area_district_id',
                'area_province_name',
                'area_city_name',
                'area_district_name',
            ]);
        });
    }
}
