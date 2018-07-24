<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FreightTemplate;
use Illuminate\Support\Facades\DB;

class FreightTemplateController extends Controller
{
    private $model = null;
    public function __construct(FreightTemplate $modle)
    {
        $this->model = $modle;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result = $this->model->paginate($request->input('pageSize', 10));
        
        return [
            'items'=>$result->items(),
            'total'=>$result->total()
        ];
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
        
        DB::beginTransaction();
        try {
            $data = $request->all();
            if ($data['is_default'] == 1) {
                $this->updateUnDefault();
            }
            $re = $this->model->create($data);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error([], $e->getMessage());
        }
        DB::commit();
        
        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
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
        DB::beginTransaction();
        try {
            $data = $request->all();
            if ($data['is_default'] == 1) {
                $this->updateUnDefault();
            }
            unset($data['id']);
            $re = $this->model->where('id', $id)->update($data);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error([], $e->getMessage());
        }
        DB::commit();
        
        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re = $this->model->destroy($id);
        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
        }
    }
    
    private function updateUnDefault()
    {
        $this->model->update(['is_default'=>0]);
    }
}
