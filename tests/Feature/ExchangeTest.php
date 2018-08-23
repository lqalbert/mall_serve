<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\AfterSale;
use Illuminate\Support\Facades\Auth;

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
        $id = 33;
        Auth::loginUsingId(1, true);
        //aa
        $aftersaleModel = AfterSale::findOrFail($id);
        //人工触发确认
        //验证
        $this->assertDatabaseHas('assign_basic', [
            'order_id' => $id
        ]);
    }
}
