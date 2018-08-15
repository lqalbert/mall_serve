<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\QuestionnaireOptions;
use App\Models\QuestionnaireManagement;


class InformationController extends CommonController
{
    //
    public function index(){
        static::$bar['bar5']='sta';
        static::$bar['line5']='line';
        $title = QuestionnaireManagement::orderBy('created_at','desc')->first()->toArray();
        $questionnaires = QuestionnaireOptions::where('questionnaire_managements_id',$title['id'])->get()->toArray();
//        var_dump($questionnaires);die;
        return view('home/information/index',['bar'=>static::$bar,'questionnaires'=>$questionnaires,'title'=>$title]);
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
}
