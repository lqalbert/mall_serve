<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\SlideUploadPicture;
class IndexController extends CommonController
{
    private $goodsBuilder = null;
    public function __construct()
    {
        $this->goodsBuilder = new Goods();
    }
    //
    public function index(){
        static::$bar['bar1']='sta';
        static::$bar['line1']='line';
        
        $indexModelFields = ['id','cover_url','goods_price','goods_name','specifications','brief'];
        
        $allgoods = Goods::all(['id','cover_url']);
        
        $newGoods = $this->goodsBuilder->active()->where([['new_goods',1]])->orderBy('id','desc')->limit(6)->select($indexModelFields)->get();
        $hotGoods = $this->goodsBuilder->active()->where([['hot_goods',1]])->orderBy('id','desc')->limit(6)->select($indexModelFields)->get();

        $data  = $this->getDatas();
        $data['newGoods'] = $newGoods;
        $data['hotGoods'] = $hotGoods;
        
        return view('index', $data);

    }

    public function getDatas(){
        $topImg = SlideUploadPicture::where('classify',SlideUploadPicture::TOP_IMG)
            ->orderBy('picture_sort')->get();//顶部
        $topName = array_column($topImg->toArray(), 'name');

        $importantGoods = SlideUploadPicture::where('classify',SlideUploadPicture::IMPORTANT_GOODS)
            ->orderBy('picture_sort')->get();//重磅新品

        $goodGoods = SlideUploadPicture::where('classify',SlideUploadPicture::GOOD_GOODS)
            ->orderBy('picture_sort')->get();//口碑之选

        $showMid = SlideUploadPicture::where('classify',SlideUploadPicture::SHOW_MID)
            ->orderBy('picture_sort')->first();//中间展示

        $imgText = SlideUploadPicture::where('classify',SlideUploadPicture::IMG_TEXT)
            ->orderBy('picture_sort')->get();//图文结合

        $showBottom = SlideUploadPicture::where('classify',SlideUploadPicture::SHOW_BOTTOM)
            ->orderBy('picture_sort')->first();//底部展示

        return [
                'bar'=>static::$bar, 
                'topImg'=>$topImg,
                'topName'=>$topName,
                'importantGoods'=>$importantGoods,
                'goodGoods'=>$goodGoods,
                'showMid'=>$showMid,
                'imgText'=>$imgText,
                'showBottom'=>$showBottom,
            ];
    }










}
