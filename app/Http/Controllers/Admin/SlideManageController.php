<?php

namespace App\Http\Controllers\Admin;

use App\Models\SlideManage;
use App\Models\SlideUploadPicture;
use App\Models\GoodsDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SlideManageController extends Controller
{

    private $request = null;
    private $model = null;

    public function  __construct(Request $request,SlideManage $slideManage)
    {
        $this->request = $request;
        $this->model = $slideManage;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $where = [];
        if ($this->request->has('classify')) {
            $where[] = ['classify',$this->request->input('classify')];
        }
        $data = $this->model->where($where)->paginate();
        return ['items'=>$data->items(), 'total'=>$data->total()];
    }
    public function slideUpload(Request $request)
    {
        $re = $this->getFileInfo();
        $data = $re;
        $data['user_id'] = $this->request->input('user_id');
        $data['goods_id'] = $this->request->input('goods_id');
        $data['name'] = $this->request->input('name');
        $uploadId = SlideUploadPicture::create($data);
        $res = $this->model->where(['classify'=>$this->request->input('classify')])->first();
        if(!$res){
            $this->model->create(['classify'=>$this->request->input('classify')]);
        }
        if (!$uploadId) {
            return $this->error(null, '保存失败');
        } else {
            return $this->success([], '上传成功');
        }
    }

    private function  getFileInfo()
    {
        $subdir = $this->request->input('subdir', 'public/Slide');
        $public = $this->request->input('ispublic', false);
        $uploadFile = $this->request->file('avatar');
        $re = [];
        $re['classify'] = $this->request->input('classify');
//        $re['file_name'] = $uploadFile->getClientOriginalName();
//        $re['size'] = $uploadFile->getClientSize();
//        $re['type'] = $uploadFile->getClientMimeType();
        if ($public) {
            $path = $uploadFile->storePublicly(config('filesystems.disks.public.visibility'));
        } else {
            $path = $uploadFile->store($subdir);
        }
        $re['cover_url'] =  Storage::url($path);
        return $re;
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
        $goods_pictures = $this->request->input('goodsPictures');
        $classify = $this->request->input('classify');
        $user_id = $this->request->input('user_id');
        $input_pictures = [];
        foreach ($goods_pictures as $k=> $v){
            $input_pictures[$k]['classify'] = $classify;
            $input_pictures[$k]['user_id'] = $user_id;
            $input_pictures[$k]['name'] = $v['goods_name'];
            $input_pictures[$k]['goods_id'] = $v['id'];
            $input_pictures[$k]['cover_url'] = $v['cover_url'];
            $input_pictures[$k]['created_at'] = date('Y-m-d h:i:s');
            $input_pictures[$k]['updated_at'] = date('Y-m-d h:i:s');
        }
        DB::beginTransaction();
        try{
            $res = SlideUploadPicture::insert($input_pictures);
            $re = $this->model->create(['classify'=>$classify]);
            if($re && $res){
                DB::commit();
            }
        }catch (\Exception $e){
            DB::rollback();
            return  $this->error([], $e->getMessage());
        }
            return $this->success([]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SlideManage  $slideManage
     * @return \Illuminate\Http\Response
     */
    public function show(SlideManage $slideManage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SlideManage  $slideManage
     * @return \Illuminate\Http\Response
     */
    public function edit(SlideManage $slideManage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SlideManage  $slideManage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SlideManage $slideManage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SlideManage  $slideManage
     * @return \Illuminate\Http\Response
     */
    public function destroy(SlideManage $slideManage,$id)
    {
      $re = $this->model->destroy($id);
      if($re){
        return  $this->success([]);
      }else{
        return  $this->error([]);

      }
    }
}
