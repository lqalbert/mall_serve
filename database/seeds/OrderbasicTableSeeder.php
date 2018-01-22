<?php

use Illuminate\Database\Seeder;

class OrderbasicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('order_basic')->insert([
            'order_sn' => str_random(8),
            'order_type' => 'rwer',
            'goods_name' => 'fsd',
            'order_status' => '1',
            'order_time' => date('Y-m-d',time()),
            'o_shop' => 'dad',
            'consignee' => 'dad',
            'print' => 'dasd',
            'order_all_money' => 33,
            'order_pay_money' => 22,
            'pay_name' => '32',
            'address' => '',
            'shipping_name' => '2321',
            'users' => '1',
            'employee' => '1',
            'user_phone' => '13333333333',
            'det_address' => '',
            'shipping_name' => '2321',
            'shipping_status' => '2',
        ]);
        DB::table('order_basic')->insert([
            'order_sn' => str_random(8),
            'order_type' => 'eeer',
            'goods_name' => 'fs',
            'order_status' => '3',
            'order_time' => date('Y-m-d',time()),
            'o_shop' => 'das',
            'consignee' => 'dsd',
            'print' => 'dassdsad',
            'order_all_money' => 13,
            'order_pay_money' => 12,
            'pay_name' => 'dad',
            'shipping_name' => 'da',
            'shipping_status' => '2',
            'address' => '',
            'users' => '1',
            'employee' => '2',
            'user_phone' => '13333333333',
            'det_address' => '',
        ]);
        DB::table('order_basic')->insert([
            'order_sn' => str_random(8),
            'order_type' => 'dsf',
            'goods_name' => 'ffsdfs',
            'order_status' => '1',
            'order_time' => date('Y-m-d',time()),
            'o_shop' => 'ds',
            'consignee' => 'as',
            'print' => 'fsd',
            'order_all_money' => 13,
            'order_pay_money' => 12,
            'pay_name' => 'dad',
            'shipping_name' => 'da',
            'shipping_status' => '3',
            'address' => '',
            'users' => '1',
            'employee' => '1',
            'user_phone' => '13333333333',
            'det_address' => '',
        ]);
    }
}
