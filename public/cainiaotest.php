<?php
// die('注释我');
$linkUrl = 'https://linkdaily.tbsandbox.com/gateway/link.do';

$content = "<request><cpCode></cpCode></request>";//[ "cpCode" => ""]; // 如果接口配置为json格式，这儿内容就是json，否则是xml格式

$appSecret = 'F53eqq903jQySV100Z8w06f9g914A13Z'; // APPKEY对应的秘钥

$cpCode = 'TmpFU1ZOUGoyRnoybDZmT3lyaW9hWGR4VFNad0xNYTBUek9QZk9kamt2Z1hJMytsVkVHK0FjVW55T25wcUR1Qw=='; //调用方的CPCODE

$msgType = 'TMS_WAYBILL_SUBSCRIPTION_QUERY'; //调用的API名

$toCode = '';//'STO'; //调用的目标TOCODE，有些接口TOCODE可以不用填写

$digest = base64_encode(md5($content.$appSecret, true)); //生成签名

echo 'digest is '.$digest."\n";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $linkUrl);

// For debugging
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // don't check certificate
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // don't check certificate

curl_setopt($ch, CURLOPT_VERBOSE, 1);

curl_setopt($ch, CURLOPT_FAILONERROR, false);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/x-www-form-urlencoded']);

$post_data = 'msg_type='.$msgType .'&to_code='.$toCode .'&logistics_interface='.urlencode(json_encode($content)) .'&data_digest='.urlencode($digest) .'&logistic_provider_id='.urlencode($cpCode);

echo "Post body is: \n".json_encode($post_data)."\n"; curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); curl_setopt($ch, CURLOPT_POST, 1);
echo "<br>";
echo "Start to run...\n"; $output = curl_exec($ch); curl_close($ch);
echo "<br>";
echo "Finished, result data is: \n".json_encode($output);