<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\DistributionCenter;
use App\Services\Inventory\System;
use App\Models\OrderGoods;

class InventoryTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    
    public function testProduce()
    {
//         $entrepot = DistributionCenter::find(1);
        
        $products = [
            ['sku_sn'=>'arg', 'goods_name'=>'aabaa', 'goods_number'=>12],
//             ['sku_sn'=>'ygyyggyy', 'goods_name'=>'abaaa', 'goods_number'=>100],
//             ['sku_sn'=>'grrg', 'goods_name'=>'aabaa', 'goods_number'=>200],
        ];
        
        $productsModels = [];
        foreach ($products as $product) {
            $productsModels[] =  OrderGoods::make($product);
        }
        
        $sys = new System();
        
        $sys->entryUpdate(1, $productsModels);
        
        $this->assertDatabaseHas('inventory_system', [
            'sku_sn' => 'arg',
            'entrepot_count'=> 52
        ]);
    }
}
