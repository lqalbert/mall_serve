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
use App\Contracts\Goods as CheckGoods;

class StockCheckGoods extends Model implements CheckGoods
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

    public function purchasePrice(){
         return $this->hasOne('App\Models\PurchaseOrderGoods', 'sku_sn','sku_sn');
    }
    
    public function getName()
    {
        return $this->goods_name;
    }
    
    public function getSkuSn()
    {
        return $this->sku_sn;
    }
    
    public function getNum()
    {
        if ($this->profit_count == 0 && $this->loss_count == 0) {
            return 0;
        }
        return $this->profit_count > 0 ? $this->profit_count : -$this->loss_count;
    }
    
    public function setFixed()
    {
        $this->is_fixed = 1;
        return $this;
    }
    
    public function setUnFixed()
    {
        $this->is_fixed = 0;
        return $this;
    }
    
    public function isFixed()
    {
        return $this->is_fixed == 1;
    }
    
    

}
