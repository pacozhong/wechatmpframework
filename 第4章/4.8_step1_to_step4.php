<?php
require_once "lib.php";

/*echo "<pre>";
var_dump($_REQUEST);  //查看所有从微信服务区传递过来的GET 或者 POST的值
echo "</pre>";*/



if(isset($_GET['code'])){

  	//p($_GET['code']); //第一次获取的数据   step1
  	 define("CODE", $_GET['code']);  //获取传递过来的code值
   	
   	//获取页面授权的ACCESS_TOKEN 、 refresh_token、openid、 scope的类型   step2
  	$get_webPage_access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".APPSECRET."&code=".CODE."&grant_type=authorization_code";
   	$json_result = getCatch($get_webPage_access_token_url);  // 
  	$arr_result = json_decode($json_result, true); //获取access_token
    p($arr_result);
  	echo $arr_result['refresh_token'];
  
  	//echo "<br />"."===============================刷新后的access_token相关信息开始==========step3 or not================================"."<br />"; 
    /*define("REFRESH_TOKEN", $arr_result['refresh_token']);
    $refresh_access_token_url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".APPID."&grant_type=refresh_token&refresh_token=".REFRESH_TOKEN;
  	$new_access_token_by_refresh_json = getCatch($refresh_access_token_url);
    $new_access_token_by_refresh_arr = json_decode($new_access_token_by_refresh_json, true); 
  	p($new_access_token_by_refresh_arr);// */
  	
  	//echo "<br />"."===============================刷新后的access_token相关信息结束==========p3================================"."<br />"; 
  
    
  	//拉取用户信息(需scope为 snsapi_userinfo)  step4
    define("ACCESS_TOKEN", $arr_result['access_token']);
   // define("ACCESS_TOKEN", $new_access_token_by_refresh_arr['access_token']); //根据刷新后的access_token拉取用户的基本信息
  	$webPageUserInfoGet_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".ACCESS_TOKEN."&openid=".$arr_result['openid'];
  	$userInfo_json = getCatch($webPageUserInfoGet_url);
  	$userInfo_arr = json_decode($userInfo_json, true);
  	p($userInfo_arr);  	//输出获取的用户信息
  
}else{
    echo "NO CODE";
}
?>

