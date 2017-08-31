<?php
//根据用户的openid的值获取用户的基本信息
require_once "lib.php";

//肉盾
define("APPID", "wx5dcde27cde9b0e52"); //APPID
define("APPSECRET", "692034a27a5fe9ccb89ae59aa5a8563b");//APPSECRET



$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET; //获取ACCESS_TOKEN请求的URL地址；
$res = file_get_contents($token_access_url);
$result = json_decode($res,true);//将获取的返回Json值转换为数组格式
$access_token = $result['access_token'];//将获取的access_token保存到临时变量中。
define("ACCESS_TOKEN", $access_token);

echo $access_token;
$get_msg_by_openid = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".ACCESS_TOKEN."&openid=o6Unjt2jQ49UywtBTLx2MBwui4BY";
$result_json = file_get_contents($get_msg_by_openid);
p($result_json);
p(json_decode($result_json, true));
