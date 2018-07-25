<?php

namespace App\Http\Controllers\Home;

use App\Models\GoodsType;
use Illuminate\Http\Request;
use App\Models\Goods;
use App\models\Category;

class ProductController extends CommonController
{
    //
    public function index(Request $request){
        static::$bar['bar2']='sta';
        static::$bar['line2']='line';
        
        $subNav = [
//             '1'=>['url'=>route('product/index', ['cate_id'=>'1']),'isactive'=>'','name'=>''],
//             '2'=>['url'=>route('product/index', ['cate_id'=>'2']),'isactive'=>'','name'=>''],
//             '3'=>['url'=>route('product/index', ['cate_id'=>'3']),'isactive'=>'','name'=>''],
//             '4'=>['url'=>route('product/index', ['cate_id'=>'4']),'isactive'=>'','name'=>'']
        ];
        $name='';
        //还是有问题 的 如果 type 有多个非一级分类就会出错
        $goodsTypeName=GoodsType::all();
//         $goodsTypeName->load('cate');
        logger("[dd]", $goodsTypeName->toArray());
        foreach ($goodsTypeName as $k=>$v){
            $subNav[$v->cate->id] = [
                'url'=>route('product/index', ['cate_id'=>$v->cate->id]),
                'isactive'=>"",
                'name' =>$v->name,
            ]   ;//             ['name']=$v['name'];
        }
        if($request->has('cate_id')){
            $subNav[$request->input('cate_id')]['isactive'] ='actionBar';
        }
        $goodsModel = new Goods;
        if($request->has('seachText')){
            $goodsModel = $goodsModel->where('goods_name', 'like', '%'.$request->input('seachText').'%');
        }
        
        if ($request->has('cate_id')) {
            $name= $subNav[$request->input('cate_id')]['name'];
            //$cate = $this->getCateByLabel($request->input('label'));
            $cate = $request->input('cate_id');
            $goodsModel = $goodsModel->whereHas('midCate',function($query) use($cate){
                $query->where('cate_id', $cate);
            });
        }else{
            $name='全部';
        }
        
        $goods = $goodsModel->select(['id','goods_name','goods_price','del_price','new_goods','cover_url','brief','specifications'])->active()->get();
        
        
//         $gust = $goodsModel->select(['id','goods_name','goods_price','del_price','new_goods','cover_url'])->active()->inRandomOrder()->limit(8)->get();

        return view('home/product/index',['bar'=>static::$bar, 'subNav'=>$subNav, 'goods'=>$goods, 'name'=>$name]);
    }

    
    public function product(Request $request, $id){
        static::$bar['bar2']='sta';
        static::$bar['line2']='line';
        
        $goods = Goods::with(['category','imgs','derectAttr'])->active()->findOrFail($id);
        $goods->derectAttr->load('spec');
        $this->setAttrGroup($goods);
        
        //推荐
        $recoms = Goods::select(['id','cover_url','goods_name','sale_count','goods_price','brief','specifications'])->limit(6)->get();
        return view('home/product/product',['bar'=>static::$bar, 'goods'=>$goods, 'recoms'=>$recoms]);
    }
    
    private function getCateByLabel($label)
    {
        return Category::where('label', $label)->firstOrFail();
    }
    
    /**
     * 这个应该抽离出去 不应该写在这里
     */
    private function setAttrGroup($model)
    {
        $group = [];
        foreach ($model->derectAttr as $sku) {
            if (!isset($group[$sku->spec->id])) {
                $group[$sku->spec->id] = $sku->spec;
                $group[$sku->spec->id]->attr = [];
            }
            $attr = $group[$sku->spec->id]->attr;
            $attr[] = ['value'=>$sku->value, 'addon_value'=>$sku->addon_value];
            $group[$sku->spec->id]->attr = $attr;
        }
        $model->groupAttr = $group;
    }
}
