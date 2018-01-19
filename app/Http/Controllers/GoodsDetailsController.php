<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoodsDetails;
use App\Repositories\GoodsDetailsRepository;
use App\Models\GoodsCategory;
use App\Models\GoodsImg;

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
        $data = [
            'goods_name'=>$request->input('goods_name'),
            'goods_price'=>$request->input('goods_price'),
            'goods_number'=>$request->input('goods_number'),
            'unit_type'=>$request->input('unit_type'),
            'description'=>$request->input('description'),
            'cover_url'=>$request->input('img_path')[0],
            'status'=>$request->input('status'),
        ];
        $re = $this->repository->create($data);

        if ($re) {
            $cateData = ['goods_id'=>$re->id];
            $imgData = ['goods_id'=>$re->id];

            foreach ($request->input('cate_id') as $k => $v) {
                $cateData['cate_id'] = $v;
                $res = $this->categoryModel->create($cateData);
                if (!$res) {
                    $this->error($res);
                }
            }

            foreach ($request->input('img_path') as $key => $value) {
                $imgData['url'] = $value;
                $resu = $this->goodsImgMdodel->create($imgData);
                if (!$resu) {
                    $this->error($resu);
                }
            }

        } else {
            return $this->error($re);
        }
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
        //
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
