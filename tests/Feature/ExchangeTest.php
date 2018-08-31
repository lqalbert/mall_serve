<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\AfterSale;
use Illuminate\Support\Facades\Auth;
use App\Models\Assign;
use App\Services\Inventory\InventoryService;
use App\Services\Inventory\System;
use App\Services\Inventory\Detail;

/**
 * 测试重新发货
 * @author hyf
 *
 */
class ExchangeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    
    public function testExchange()
    {
        $id = 5;
        Auth::loginUsingId(1, true);
        //aa
        $aftersaleModel = AfterSale::findOrFail($id);
        $order = $aftersaleModel->order;
        $goods = $order->goods;
        $exchangeGoods = $goods->filter(function($value){
            return $value->isExchange();
        });
        
        if ($exchangeGoods->count() > 0) {
            
            //生成发货单;
            //库存修改
            //先临时这么写
            $data = [
                'entrepot_id'=> $aftersaleModel->entrepot_id,
                'order_id'   => $aftersaleModel->order_id,
                'address_id' => $aftersaleModel->order->address_id,
            ];
            $assignmodel = Assign::create($data);
            if (!$assignmodel) {
                logger("[test]", ["assign model fail"]);
                $this->assertTrue(false);;
            }
            $newGoods = [];
            foreach ($exchangeGoods as $xGoods){
                $newModel = $xGoods->replicate();
                $newModel->setExchangeStatus();
                $newModel->save();
                $newGoods[]  = $newModel;
            }
            
            $service = new InventoryService(new System(), new Detail());
            $service->exLock($aftersaleModel->order->entrepot, $newGoods, auth()->user(), $aftersaleModel->return_sn);
            
            //验证
            $this->assertDatabaseHas('assign_basic', [
                'order_id' => 33
            ]);
        } else {
            $this->assertTrue(false);
        }
        
    }
}
