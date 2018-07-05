<?php
namespace App\Services\WayBill\CainiaoRequest;



use Illuminate\Support\Facades\Storage;

class Request 
{
    private $url = "";
    private $code = "";
    private $app_key = "";
    private $app_secret="";
    
    private $api = "";
    private $content = "";
    private $to_code = "";
    
    private $dataType = "";
    
    public function __construct() 
    {
        
        if (env('APP_ENV') != "production") {
            $this->url =  config('cainiao.test_url');
            $this->code = config('cainiao.test.code');
            $this->app_key = config('cainiao.test.app_key');
            $this->app_secret = config('cainiao.test.app_secret');
        } else {
            $this->url = config('cainiao.api_url') ;
            $this->code = config('cainiao.code');
            $this->app_key = config('cainiao.app_key');
            $this->app_secret = config('cainiao.app_secret');
        }
       
    }
    
    
    public function setDataType($str)
    {
        $this->dataType = $str;
        return $this;
    }
    
    public function setParam($obj)//  String $api, array $content, String $toCode=null)
    {
        
        $this->api = $obj->getApi();
        $this->content = $obj->getContent($this->dataType);
        $this->to_code = $obj->getToCode();
        return $this;
    }
    
    public function makeSign()
    {
        Storage::disk('local')->put('request.xml', $this->content);
        return base64_encode(md5($this->content.$this->app_secret, true));
    }
    
    public function getBody()
    {
        return http_build_query([
            'msg_type'=> $this->api, //这个是API名称
            'to_code' => $this->to_code, //与具体的打印参数有关　比如　不同的快递公司　不同的code
            'logistics_interface'=> $this->getContent(),
            'data_digest' => $this->makeSign(), //$digest, //签名
            'logistic_provider_id'=> $this->code
        ]);
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
//     public function toXml($data)
//     {
//         if(!is_array($data) || count($data) <= 0){
//             return false;
//         }
//         $xml = "<request>";
//         $xml .= $this->array2xml($data);
//         $xml.="</request>";
//         Storage::disk('local')->put('request.xml', $xml);
//         return $xml;  
//     }
    
//     private function array2xml($data)
//     {
//         if(!is_array($data) || count($data) <= 0){
//             return false;
//         }
//         $xml = "";
//         foreach ($data as $key=>$val){
//             if (is_string($val)) {
//                 $prev = "<".$key.">";
//                 $prev.="</".$key.">";
//                 $xml .= $prev;
//             } else if(is_array($val)){
//                 $xml .= $this->array2xml($val);
//             }
//             if (!is_numeric($key)) {
//                 $prev = "<".$key.">";
//                 if (is_array($val) or is_object($val)){
//                     $prev.= $this->array2xml($val);
//                 }else{
//                     $prev.=$val;
//                 }
//                 $prev.="</".$key.">";
//                 $xml .= $prev;
//             } else {
//                 $xml .= $this->array2xml($val);
//             }    
//         }
        
//         return $xml;  
        
//     }
    
    public function send()
    {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->url);
        //下面这句　标准错输出啊　，查看命令行界面　正式的时候不需要
        if (env('APP_ENV') != "production") {
            curl_setopt($ch, CURLOPT_VERBOSE, 1);//启用时会汇报所有的信息，存放在STDERR或指定的CURLOPT_STDERR中,没明白什么意思
        }
        
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);//显示HTTP状态码
        curl_setopt($ch, CURLOPT_POST, 1); //以POST方法提交
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 我用上面这行替换了
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//返回信息
        //因为我用 CURLOPT_POST 替换　CURLOPT_CUSTOMREQUEST　好像这里就不用设置了
//         curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/x-www-form-urlencoded']);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getBody());
        //curl_setopt($ch, CURLOPT_POST, 1); demo上这里是有设置的　我暂时注释掉
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // don't check certificate
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // don't check certificate

//         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
//         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在

        $output = curl_exec($ch); 
        
        if ($output === false) {
            logger('[cainiao]',[curl_errno($ch), curl_error($ch)]);
        }
//         $headerContent = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
//         logger("[cainiao-content]",[$headerContent]);
        curl_close($ch);
        
        return $output;
    }
}