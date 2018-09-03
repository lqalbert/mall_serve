<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\QuestionnaireOptions;
use App\Models\QuestionnaireManagement;
use Gregwar\Captcha\CaptchaBuilder;
use App\Models\QuestionnaireSurveyResults;
use Illuminate\Support\Facades\DB;

class InformationController extends CommonController
{
    //
    public $builder = null;
    public $request = null;
    public $model = null;

    public function __construct(QuestionnaireSurveyResults $QuestionnaireSurveyResults,Request $request,CaptchaBuilder $builder){
        parent::__construct();
        $this->builder = $builder;
        $this->request = $request;
        $this->model = $QuestionnaireSurveyResults;

    }
    public function index($id){
        static::$bar['bar5']='sta';
        static::$bar['line5']='line';
        $title = QuestionnaireManagement::where('id',$id)->first()->toArray();
//        $title = QuestionnaireManagement::where('id',$this->request->input('id'))->first()->toArray();
        $questionnaires = QuestionnaireOptions::where('questionnaire_managements_id',$title['id'])->get()->toArray();
        $ids = array_column($questionnaires,'id');
        $this->request->session()->put(['questionnaires_ids'=>$ids]);
        return view('home/information/index',['bar'=>static::$bar,'questionnaires'=>$questionnaires,'title'=>$title]);
    }
    //生成验证码
    public function verificationCode(Request $request) {
        //生成验证码图片的Builder对象，配置相应属性
        //可以设置图片宽高及字体
        $this->builder->build($width = 120, $height = 35, $font = null);
        //获取验证码的内容
        $phrase = $this->builder->getPhrase();
        //把内容存入session
        $request->session()->put(['verification_code'=>$phrase]);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        return $this->builder->output();

    }
    public function verifyCaptcha() {
        $userInputCode = $this->request->input('code');
        if ($this->request->session()->get('verification_code') == $userInputCode) {
            return true;
        } else {
            return false;
        }
    }
    public function saveUserAnswers(Request $request)
    {
        $res = $this->verifyCaptcha();
        if(!$res){
            return $this->error([],'验证码输入不正确!',0);
        }
        $data = $this->request->all();
        $questionnaires_ids = $this->request->session()->get('questionnaires_ids');
//        $phone = $data['cus_phone'];
        $phone = $this->request->session()->get('user_login_phone');
        $user = DB::table('customer_contact')->where('phone',$phone)->first();
        $answers = ['answer_a','answer_b','answer_c','answer_d','answer_e'];
        if(!$user){
            return $this->error([],'你还没有注册!',0);
        }else {
            $cus_id = $user->cus_id;
            $has_user = DB::table('questionnaire_survey_results')->where('cus_id',$cus_id)->first();
            if(!$has_user){
                foreach ($questionnaires_ids as $k1 =>$v1){
                    $tmp = [];
                    $tmp_name = 'question_'.$v1;
                    if(in_array($tmp_name,array_keys($data))){
                        $tmp['questionnaire_managements_id'] = (int)$data['questionnaire_managements_id'];
                        $tmp['cus_id'] = $cus_id;
                        $tmp['questionnaire_options_id'] = $v1;
                        $tmp['created_at'] = date('Y-m-d H:i:s',time());
                        $tmp['updated_at'] = date('Y-m-d H:i:s',time());
                        $values = explode(',',$data[$tmp_name]);
                        foreach ($values as $k=>$v){
                            if(in_array($v,$answers)){
                                $tmp[$v] = 1;
                            }else{
                                $tmp['answer'] = $data[$tmp_name];
                            }
                        }
                        $this->model->create($tmp);
                    }
                }
                return $this->success([],'提交成功，谢谢你的参与!',1);
            }
            else{
                return $this->error([],'你已提交过答案，请不要重复提交！',0);
            }

        }

    }
    public function news(){
        static::$bar['bar6']='sta';
        static::$bar['line6']='line';
        $articles = Article::orderBy('id', 'desc')->paginate(15);
        $articles2 = Article::orderBy('id', 'desc')->limit(10)->get();
        return view('home/information/news',['bar'=>static::$bar, 'articles'=>$articles, 'articles2'=>$articles2]);
    }
    
    public function detail($id)
    {
        static::$bar['bar6']='sta';
        static::$bar['line6']='line';
        $article = Article::findOrFail($id);
        $articles2 = Article::orderBy('id', 'desc')->limit(10)->get();
        $prev = Article::where('id','<',$id)->select(['id','title'])->first();
        $next = Article::where('id','>',$id)->select(['id','title'])->first();
        return view('home/information/newshow', ['article'=>$article, 'articles'=>$articles2, 'bar'=>static::$bar, 'prev'=>$prev, 'next'=>$next]);
    }
    public function company(){
        return  view('home/information/company',['bar'=>static::$bar]);
    }
}
