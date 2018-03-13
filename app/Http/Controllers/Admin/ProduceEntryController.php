<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProduceEntry;
use App\Models\ProduceEntryProduct;
class ProduceEntryController extends Controller
{


    private $parentModel = null;
    private $childModel = null;

    public function  __construct(ProduceEntry $ProduceEntry,ProduceEntryProduct $ProduceEntryProduct)
    {
        $this->parentModel = $ProduceEntry;
        $this->childModel = $ProduceEntryProduct;

    }

    public function store(Request $request)
    {

//        $p_data['user_name'] = $request->input('user_name');
//        $p_data['user_id'] = $request->input('user_id');
//        $p_data['entrepot_id'] = $request->input('entrepot_id');
//        $p_data['comment'] = $request->input('comment');
//        $p_data['entry_at'] = $request->input('entry_at');
//        $p_data = $request->input('parentData');

        $p_data = $request->input('parentData');
        $re = $this->parentModel->create($p_data);

        $parent_id = $re->id;
        $time = $re->created_at;
//        var_dump($re->id);die();
//        $c_data['parent_id'] = $this->parentModel->id;
//        $c_data['cate_type'] = $request->input('cate_type');
//        $c_data['cate_kind'] = $request->input('cate_kind');
//        $c_data['cate_type_id'] = $request->input('cate_type_id');
//        $c_data['cate_kind_id'] = $request->input('cate_kind_id');
//        $c_data['product_sale_type'] = $request->input('product_sale_type');
//        $c_data['goods_name'] = $request->input('goods_name');
//        $c_data['sku_sn'] = $request->input('sku_sn');
//        $c_data['num'] = $request->input('num');

        $c_data=[];
        foreach ($request->input('childrenData') as $k => $v){
            $v['parent_id'] = $parent_id;
            $v['created_at'] = $time;
            $v['updated_at'] = $time;
            $c_data[$k] = $v;
        }

        $this->childModel->insert($c_data);

    }
    
}