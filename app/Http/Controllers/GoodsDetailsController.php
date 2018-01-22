<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoodsDetails;
use App\Repositories\GoodsDetailsRepository;
use App\Models\GoodsCategory;
use App\Models\GoodsImg;
use App\Models\Goods;

class GoodsDetailsController extends Controller
{

    private $repository = null;
    private $categoryModel = null;
    private $goodsImgMdodel = null;
    public function  __construct(GoodsDetailsRepository $goodsDetailsRepository,GoodsCategory $goodsDetails,GoodsImg $goodsImg) 
    {
        $this->repository = $goodsDetailsRepository;
        $this->categoryModel = $goodsDetails;
        $this->goodsImgMdodel = $goodsImg;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $business = $request->query('business', 'default');
        $result = [];
        switch ($business) {
            case 'UnitTypes':
                $result = GoodsDetails::getUnitTypes();
                break;
            
            default:
                $service = app('App\Services\GoodsDetails\GoodsDetailsService');
                $result = $service->get();
                break;
        }
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    	//事务
    	$goodsModel = Goods::create($request->all());
    	
    	$imgs = $request->input('img_path', []);
    	foreach ($imgs as $img){
    		$imgModel = $goodsModel->imgs()->create(['url'=>$img]);
    	}
    	
    	$cates = $request->input('cate_id', []);
    	$goodsModel->category()->attach($cates);
    	// end of 事务
    	
    	return $this->success($goodsModel);
    	
    	
    	
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	//$cates = $request->input('cate_id', []);
    	//$goodsModel->cateogry()->sync($cates);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //返回 int
        $re = $this->repository->delete($id);
        if ($re) {
            return $this->success($re);
        } else {
            return $this->error($re);
        }
    }






}
