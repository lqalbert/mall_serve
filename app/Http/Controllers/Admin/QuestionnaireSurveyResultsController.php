<?php

namespace App\Http\Controllers\Admin;

use App\Models\QuestionnaireSurveyResults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\QuestionnaireOptions;
class QuestionnaireSurveyResultsController extends Controller
{
    public $model = null;
    public $request = null;
    public function __construct(QuestionnaireSurveyResults $QuestionnaireSurveyResults,Request $request){
        $this->model = $QuestionnaireSurveyResults;
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = $this->request->input('type');
        switch($type){
            case 'results_ratio':
                return $this->getSurveyResults();
                break;
            case 'users':
                return $this->getUsers();
                break;
            case 'user_answer':
                return $this->getUserAnswer();
                break;
            case 'info':
                return $this->getInfo();
                break;
        }


    }

    public function getSurveyResults()
    {
        $questionnaire_managements_id = $this->request->input('questionnaire_managements_id');
        $data = DB::table('questionnaire_survey_results as r')
            ->select(DB::raw("sum(r.answer_a) as a_total,sum(r.answer_b) as b_total,sum(r.answer_c) as c_total,sum(r.answer_d) as d_total,sum(r.answer_e) as e_total,q.problem_type,q.topic_name,r.answer,r.questionnaire_options_id,r.questionnaire_managements_id"))
            ->join('questionnaire_options as q','q.id','=','r.questionnaire_options_id')
            ->where('r.questionnaire_managements_id',$questionnaire_managements_id)
            ->groupBy('r.questionnaire_options_id')
            ->get()
            ->toArray();
//        var_dump($data);die;

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

    public function getUsers()
    {
        $where=[];
        if($this->request->has('name')){
            $where[] = ['c.name',$this->request->input('name')];
        }
        if($this->request->has('weixin_nickname')){
            $where[] = ['cc.weixin_nickname',$this->request->input('weixin_nickname')];
        }
        if($this->request->has('phone')){
            $where[] = ['cc.phone',$this->request->input('phone')];
        }
        $questionnaire_managements_id = $this->request->input('questionnaire_managements_id');
        $data = DB::table('questionnaire_survey_results as r')
            ->select(DB::raw("c.name,cc.phone,cc.weixin_nickname,r.cus_id as cus_id"))
            ->join('customer_basic as c','c.id','=','r.cus_id')
            ->join('customer_contact as cc','cc.cus_id','=','r.cus_id')
            ->where($where)
            ->where('r.questionnaire_managements_id',$questionnaire_managements_id)
            ->groupBy('r.cus_id')
            ->orderBy('c.created_at','desc')
            ->paginate($this->request->input('pageSize'));
        return ['users'=>$data->items(),'total'=>$data->total()];

    }

    public function getUserAnswer()
    {
        $questionnaire_managements_id = $this->request->input('questionnaire_managements_id');
        $cus_id = $this->request->input('cus_id');
        $options = QuestionnaireOptions::where('questionnaire_managements_id',$questionnaire_managements_id)->get()->toArray();
        $res =$this->model
            ->where('questionnaire_managements_id',$questionnaire_managements_id)
            ->where('cus_id',$cus_id)
            ->get()
            ->toArray();
        $str = ['a','b','c','d','e'];
        $data = [];
        foreach($options as $k1=>$v1){
            foreach ($res as $k=>$v ){
                if($v['questionnaire_options_id'] == $v1['id']){
                    foreach ($str as $k3=>$v3){
                        $data1 = [];
                        if($v['answer_'.$v3]){
                            //判断某个题目是否是多选，如果是则将选择的答案进行拼接
                            if(in_array($v['questionnaire_options_id'],array_column($data,'questionnaire_options_id'))){
                                foreach ($data as $k2=>$v2){
                                    if($v2['questionnaire_options_id'] == $v['questionnaire_options_id']){
                                        $data[$k2]['option'] = $data[$k2]['option'].','.strtoupper($v3);
                                        $data[$k2]['choice_answer'] = $data[$k2]['choice_answer'].';'.$v1['option_'.$v3];
                                    }
                                }
                            }else{
                                //题目答案不是多选则直接添加到数组中
                                $data1['questionnaire_options_id'] = $v['questionnaire_options_id'];
                                $data1['topic_name'] = $v1['topic_name'];
                                $data1['option'] = strtoupper($v3);
                                $data1['choice_answer'] = $v1['option_'.$v3];
                                array_push($data,$data1);
                            }

                        }
//                       //添加填空题答案到数组
                        if($v['answer']){
                            $data1['questionnaire_options_id'] = $v['questionnaire_options_id'];
                            $data1['topic_name'] = $v1['topic_name'];
                            $data1['fill_answer'] = $v['answer'];
                            //除去重复添加填空题答案
                            if(!in_array($data1,$data)){
                                array_push($data,$data1);
                            }
                        }
                    }

                }
            }
        }
          return ['answers'=>$data,'total'=>count($data)];

    }

    public function getInfo()
    {
        $questionnaire_managements_id = $this->request->input('questionnaire_managements_id');
        $questionnaire_options_id = $this->request->input('questionnaire_options_id');
        $problem_type = $this->request->input('problem_type');
        $info = [];
        $options = [];
        if($problem_type==3){
            $info = DB::table('questionnaire_survey_results as r')
                ->select('q.topic_name','r.answer','r.id')
                ->join('questionnaire_options as q','q.id','=','r.questionnaire_options_id')
                ->where('r.questionnaire_managements_id',$questionnaire_managements_id)
                ->where('r.questionnaire_options_id',$questionnaire_options_id)
                ->get()
                ->toArray();
        }
        if($problem_type==1 || $problem_type==2){
            $option = DB::table('questionnaire_options')
                ->select('option_a as A','option_b as B','option_c as C','option_d as D','option_e as E')
                ->where('questionnaire_managements_id',$questionnaire_managements_id)
                ->where('id',$questionnaire_options_id)
                ->get()
                ->toArray();
            $options = [];
            foreach ($option as $k=>$v){
                if($v->A){
                    $options[]=['name'=>'A','comment'=>$v->A];
                }
                if($v->B){
                    $options[]=['name'=>'B','comment'=>$v->B];
                }
                if($v->C){
                    $options[]=['name'=>'C','comment'=>$v->C];
                }
                if($v->D){
                    $options[]=['name'=>'D','comment'=>$v->D];
                }
                if($v->E){
                    $options[]=['name'=>'E','comment'=>$v->E];
                }

            }
        }
//        var_dump($info);
//        var_dump($option,$options);die;
        return ['info'=>$info,'option'=>$options];
//        return ['items'=>$data];
//        var_dump($data);die;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionnaireSurveyResults  $questionnaireSurveyResults
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionnaireSurveyResults $questionnaireSurveyResults)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionnaireSurveyResults  $questionnaireSurveyResults
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionnaireSurveyResults $questionnaireSurveyResults)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionnaireSurveyResults  $questionnaireSurveyResults
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionnaireSurveyResults $questionnaireSurveyResults)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionnaireSurveyResults  $questionnaireSurveyResults
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionnaireSurveyResults $questionnaireSurveyResults)
    {
        //
    }
}
