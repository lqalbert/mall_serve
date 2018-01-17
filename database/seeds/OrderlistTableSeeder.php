<?php

use Illuminate\Database\Seeder;

class OrderlistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('orderlist')->insert([
            'order_sn' => str_random(8),
            'order_type' => 'rwer',
            'goods_name' => 'fsd',
            'order_status' => 'pre_affirm',
            'order_time' => date('Y-m-d',time()),
            'o_shop' => 'dad',
            'consignee' => 'dad',
            'print' => 'dasd',
            'order_all_money' => 33,
            'order_pay_money' => 22,
            'pay_name' => '32',
            'address' => '',
            'shipping_name' => '2321',
            'shipping_status' => 'pre_deliver',
            'users' => '1',
            'employee' => '1',
            'user_phone' => '13333333333',
            'det_address' => '',
        ]);
        DB::table('orderlist')->insert([
            'order_sn' => str_random(8),
            'order_type' => 'eeer',
            'goods_name' => 'fs',
            'order_status' => 'refund',
            'order_time' => date('Y-m-d',time()),
            'o_shop' => 'das',
            'consignee' => 'dsd',
            'print' => 'dassdsad',
            'order_all_money' => 13,
            'order_pay_money' => 12,
            'pay_name' => 'dad',
            'shipping_name' => 'da',
            'shipping_status' => 'delivered',
            'address' => '',
            'users' => '1',
            'employee' => '2',
            'user_phone' => '13333333333',
            'det_address' => '',
        ]);
        DB::table('orderlist')->insert([
            'order_sn' => str_random(8),
            'order_type' => 'dsf',
            'goods_name' => 'ffsdfs',
            'order_status' => 'closed',
            'order_time' => date('Y-m-d',time()),
            'o_shop' => 'ds',
            'consignee' => 'as',
            'print' => 'fsd',
            'order_all_money' => 13,
            'order_pay_money' => 12,
            'pay_name' => 'dad',
            'shipping_name' => 'da',
            'shipping_status' => 'pre_deliver',
            'address' => '',
            'users' => '1',
            'employee' => '1',
            'user_phone' => '13333333333',
            'det_address' => '',
        ]);
    }
}
