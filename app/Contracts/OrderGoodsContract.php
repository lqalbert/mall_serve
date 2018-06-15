<?php
namespace App\Contracts;

interface OrderGoodsContract 
{
    public function getOrder();
    public function getGoods();
}