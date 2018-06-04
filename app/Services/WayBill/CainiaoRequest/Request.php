<?php
namespace App\Services\WayBill\CainiaoRequest;



class Request 
{
    private $url = "";
    private $code = "";
    private $app_key = "";
    private $app_secret="";
    
    private $api = "";
    private $content = "";
    private $to_code = "";
    
    public function __construct() 
    {
        $this->url = env('APP_ENV') != "production" ? config('cainiao.test_url') : config('cainiao.api_url') ;
        $this->code = config('cainiao.code');
        $this->app_key = config('cainiao.app_key');
        $this->app_secret = config('cainiao.app_secret');
            
    }
    
    public function setParam(String $api, array $content, String $toCode)
    {
        $this->api = $api;
        $this->content = $content;
        $this->to_code = $toCode;
    }
    
    public function makeSign()
    {
        return base64_encode(md5(json_encode($this->content).$this->app_secretecret, true));
    }
    
    public function setBody()
    {
        $this->postBody = http_build_query([
            'msg_type'=> $this->api, //这个是API名称
            'to_code' => $this->to_code, //与具体的打印参数有关　比如　不同的快递公司　不同的code
            'logistics_interface'=> json_encode($this->content),
            'data_digest' => $this->makeSign(), //$digest, //签名
            'logistic_provider_id'=> $this->code
        ]);
    }
    
    public function send()
    {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);//启用时会汇报所有的信息，存放在STDERR或指定的CURLOPT_STDERR中,没明白什么意思
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);//显示HTTP状态码
        curl_setopt($ch, CURLOPT_POST, 1); //以POST方法提交
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 我用上面这行替换了
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//返回信息
        //因为我用 CURLOPT_POST 替换　CURLOPT_CUSTOMREQUEST　好像这里就不用设置了
        //curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/x-www-form-urlencoded']);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postBody);
        //curl_setopt($ch, CURLOPT_POST, 1); demo上这里是有设置的　我暂时注释掉
        
        $output = curl_exec($ch); 
        curl_close($ch);
        return $output;
    }
}