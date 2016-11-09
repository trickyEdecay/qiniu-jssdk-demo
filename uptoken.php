<?php
//echo time()+3600;
$uptoken = new stdClass();
$uptoken->{'uptoken'} = getuptoken();
echo json_encode($uptoken);

function getuptoken(){
    
    //两个key从七牛后台获取
    $AccessKey = "";
    $secretKey = "";
    
    //空间名称
    $bucketname = "";
    
    $deadline = time()+3600;
    $filename = time()."-".substr(md5(microtime()),0,5);
    
    $policy =  new stdClass();
    $policy->{'scope'} = $bucketname;
    $policy->{'deadline'} = $deadline;
    
    $putPolicy = json_encode($policy);
    $encodedPutPolicy = base64_urlSafeEncode($putPolicy);
    
    $sign = hash_hmac('sha1', $encodedPutPolicy, $secretKey, true);
    $encodedSign = base64_urlSafeEncode($sign);
    return $AccessKey . ':' . $encodedSign . ':' . $encodedPutPolicy;
}

//安全的url编码
function base64_urlSafeEncode($data)
{
    $find = array('+', '/');
    $replace = array('-', '_');
    return str_replace($find, $replace, base64_encode($data));
}

?>