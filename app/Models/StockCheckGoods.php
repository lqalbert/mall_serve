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

class StockCheckGoods extends Model
{
    protected $table = 'inventory_check_goods';
    
    protected $fillable = [
        // 'check_num',
        'check_id',
        'cate_kind_id',
        'cate_type_id',
        'cate_type',
        'cate_kind',
        'check_count',
        'entrepot_count',
        // 'entrepot_id',
        // 'entrepot_name',
        'goods_name',
        'goods_price',
        'inventory_id',
        'loss_count',
        'loss_money',
        'profit_count',
        'profit_money',
        'remark',
        'sku_sn',
        'check_user_id',
        'check_name',
    ];
    
    public function check()
    {
        return $this->belongsTo('App\Models\StockCheck', 'check_id');
    }
}
