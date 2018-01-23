<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class GoodsTypeTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('goods_type')->insert([
				['type_name'=>'面膜'],
				['type_name'=>'爽肤']
		]);
	}
}
