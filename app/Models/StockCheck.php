<?php
/**
 * 
 * @var cate_type_id
 * @var cate_kind_id
 * @var product_sale_type
 * @var sku_sn
 * @var cate_type
 * @var cate_kind
 * 
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockCheck extends Model
{
    protected $table = 'inventory_check';
    
    protected $fillable = [
        'sku_sn',
        'entrepot_id',
        'goods_name',
        'cate_type_id',
        'check_status',
        'entrepot_count',
        'check_count',
        'goods_price',
        'profit_count',
        'profit_money',
        'loss_count',
        'loss_money',
        'check_name',
        'check_id',
        'remark',
    ];
    
    public function check()
    {
        return $this->hasMany('App\Modles\InventroySystem', 'sku_sn', 'sku_sn');
    }
}
