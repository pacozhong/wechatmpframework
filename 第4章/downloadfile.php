<?php
function downloadfile($url, $filename="", $timeout=60) {
    $filename = empty($file) ? pathinfo($url,PATHINFO_BASENAME) : $filename;

    $result = pathinfo($url);
    $time = date("Y-m-d_H_i_s", time());
   // $filename = "./catchFile/".$time.'.'.$result['extension'];
    $filename = "./catchFile/".$time.'.jpg';
    
    $dir = pathinfo($filename,PATHINFO_DIRNAME);

    !is_dir($dir) && @mkdir($dir,0755,true);

    //var_dump($url);
    $url = str_replace(" ","%20",$url);
    //echo "<br />"."asdfasdf"."<br />";
  
    if(function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //$size =  curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        //var_dump($size);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  //抓取https 链接的设置
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $temp = curl_exec($ch);
        if(@file_put_contents($filename, $temp) && !curl_error($ch)) {
            return $filename;
        } else {
            return false;
        }
    }else {
        $opts = array(
            "http"=>array(
            "method"=>"GET",
            "header"=>"",
            "timeout"=>$timeout)
        );
        $context = stream_context_create($opts);
        if(@copy($url, $file, $context)) {
            //$http_response_header
            return $file;
        } else {
            return false;
        }
    }
}