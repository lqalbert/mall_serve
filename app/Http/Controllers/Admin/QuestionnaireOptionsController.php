<?php

namespace App\Http\Controllers\Admin;

use App\Models\QuestionnaireOptions;
use Illuminate\Http\Request;

class QuestionnaireOptionsController extends Controller
{
    public $model = null;
    public function __construct(QuestionnaireOptions $questionnaireoptions){
        $this->model = $questionnaireoptions;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if($request->has('questionnaire_options_id')){
            $questionnaire_options_id = $request->input('questionnaire_options_id');
            $where[] = ['id','=',$questionnaire_options_id];
        }
        $data = $this->model->where($where)->get()->toArray();
        return ['items'=>$data,'total'=>count($data)];
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionnaireOptions  $questionnaireOptions
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionnaireOptions $questionnaireOptions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionnaireOptions  $questionnaireOptions
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionnaireOptions $questionnaireOptions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionnaireOptions  $questionnaireOptions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $res =   $this->model->where('id',$id)->update($data);
        if($res){
            return $this->success([]);
        }else{
            return $this->error([]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionnaireOptions  $questionnaireOptions
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->model->destroy($id);
        if($res){
            return $this->success([]);
        }else{
            return $this->error([]);
        }

    }
}
