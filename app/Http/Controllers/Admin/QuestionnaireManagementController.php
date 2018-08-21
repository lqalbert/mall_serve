<?php

namespace App\Http\Controllers\Admin;

use App\Models\QuestionnaireManagement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\QuestionnaireOptions;
use Illuminate\Support\Facades\DB;
use App\Models\QuestionnaireSurveyResults;

class QuestionnaireManagementController extends Controller
{
    public $model = null;
    public function __construct(QuestionnaireManagement $questionnaireManagement){
        $this->model = $questionnaireManagement;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if($request->has('title')){
            $where[] = ['title','=',$request->input('title')];
        }
       $data = $this->model->where($where)->orderBy('created_at','desc')->paginate($request->input('pageSize'));
        return ['items'=>$data->items(),'total'=>$data->total()];
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



    public function getSurveyResults(Request $request,$questionnaire_managements_id)
    {
        $data = DB::table('questionnaire_survey_results as r')
            ->select(DB::raw("sum(r.answer_a) as a_total,sum(r.answer_b) as b_total,sum(r.answer_c) as c_total,sum(r.answer_d) as d_total,sum(r.answer_e) as e_total,q.problem_type,q.topic_name,r.answer"))
            ->join('questionnaire_options as q','q.id','=','r.questionnaire_options_id')

            ->where('r.questionnaire_managements_id',$questionnaire_managements_id)
            ->groupBy('r.questionnaire_options_id')
            ->get()
            ->toArray();
        foreach($data as $k=>$v){
            $data[$k]->a_ratio =($v->a_total+$v->b_total+$v->c_total+$v->d_total+$v->e_total) ? round( ($v->a_total / ($v->a_total+$v->b_total+$v->c_total+$v->d_total+$v->e_total)),4) * 100 .'%' : '';
            $data[$k]->b_ratio =($v->a_total+$v->b_total+$v->c_total+$v->d_total+$v->e_total) ? round( ($v->b_total / ($v->a_total+$v->b_total+$v->c_total+$v->d_total+$v->e_total)),4) * 100 .'%' : '';
            $data[$k]->c_ratio =($v->a_total+$v->b_total+$v->c_total+$v->d_total+$v->e_total) ? round( ($v->c_total / ($v->a_total+$v->b_total+$v->c_total+$v->d_total+$v->e_total)),4) * 100 .'%' : '';
            $data[$k]->d_ratio =($v->a_total+$v->b_total+$v->c_total+$v->d_total+$v->e_total) ? round( ($v->d_total / ($v->a_total+$v->b_total+$v->c_total+$v->d_total+$v->e_total)),4) * 100 .'%' : '';
            $data[$k]->e_ratio =($v->a_total+$v->b_total+$v->c_total+$v->d_total+$v->e_total) ? round( ($v->e_total / ($v->a_total+$v->b_total+$v->c_total+$v->d_total+$v->e_total)),4) * 100 .'%' : '';
        }
        return $this->success($data);
//        return ['items'=>$data];
//        var_dump($data);die;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $data = $request->except('optionsData');
        $data['user_id'] = $user->id;
        $data['user_name'] = $user->realname;
        $optionsData = $request->input('optionsData');
        DB::beginTransaction();
        try{
            $res = $this->model->create($data);
            foreach ($optionsData as $k=>$v){
                $optionsData[$k]['questionnaire_managements_id'] = $res->id;
                $optionsData[$k]['created_at'] =  Carbon::now();
                $optionsData[$k]['updated_at'] =  Carbon::now();
            }
            $re = QuestionnaireOptions::insert($optionsData);
            if($res && $re){
                DB::commit();
            }
        }catch (\Error $e){
            DB::rollback();
            throw $e;
        }
        return $this->success([]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionnaireManagement  $questionnaireManagement
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionnaireManagement $questionnaireManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionnaireManagement  $questionnaireManagement
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionnaireManagement $questionnaireManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionnaireManagement  $questionnaireManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionnaireManagement $questionnaireManagement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionnaireManagement  $questionnaireManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionnaireManagement $questionnaireManagement)
    {
        //
    }
}
