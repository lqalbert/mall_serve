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
            'deal_id' => 2,
            'deal_name' => '',
            'auditor_id' => 1,
            'auditor_name' => 'admin',
            'cus_id'  => 1,
            'address_id'  => 1,
            'goods_id' => '1,2,3',
            'order_status' => '1',
            'order_all_money'  => 13,
            'order_pay_money' => '12.00',
            'shipping_status' => '1',
            'check_status' => '0',
            'distribution_type' => '',
            'order_time' => date('Y-m-d',time()),
        ]);
        DB::table('order_basic')->insert([
            'deal_id' => 3,
            'deal_name' => '',
            'auditor_id' => 1,
            'auditor_name' => 'admin',
            'cus_id'  => 2,
            'address_id'  => 2,
            'goods_id' => '2,3,4',
            'order_status' => '0',
            'order_all_money'  => 22,
            'order_pay_money' => '22.00',
            'shipping_status' => '2',
            'check_status' => '0',
            'distribution_type' => '',
            'order_time' => date('Y-m-d',time()),
        ]);
        DB::table('order_basic')->insert([
            'deal_id' => 4,
            'deal_name' => '',
            'cus_id'  => 2,
            'address_id'  => 2,
            'goods_id' => '3,4,5',
            'order_status' => '0',
            'order_all_money'  => 22,
            'order_pay_money' => '22.00',
            'shipping_status' => '2',
            'check_status' => '0',
            'distribution_type' => 'fsdf',
            'order_time' => date('Y-m-d',time()),
        ]);
    }
}
