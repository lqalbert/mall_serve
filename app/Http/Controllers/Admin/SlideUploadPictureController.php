<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Models\SlideManage;
use App\Models\SlideUploadPicture;
use Illuminate\Http\Request;

class SlideUploadPictureController extends Controller
{
    private $request = null;
    private $model = null;

    public function  __construct(Request $request,SlideUploadPicture $SlideUploadPicture)
    {
        $this->request = $request;
        $this->model = $SlideUploadPicture;
    }

    public function index()
    {
        $where = [];
        if ($this->request->has('classify')) {
            $where[] = ['classify',$this->request->input('classify')];
        }
        $data = $this->model->where($where)->orderBy('picture_sort')->paginate();
        return ['items'=>$data->items(), 'total'=>$data->total()];
    }
    public function update(Request $request, $id)
    {
        $re = $this->model->where('id',$id)->update($this->request->all());
        if ($re) {
            return $this->success($re);
        } else {
            return $this->error([]);
        }
    }

    public function destroy($id)
    {
        $re = $this->model->destroy($id);
        if($re){
            return  $this->success([]);
        }else{
            return  $this->error([]);
        }
    }
}
