<?php
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
//$get_group_msg_url = "https://api.weixin.qq.com/cgi-bin/groups/get?access_token=".ACCESS_TOKEN;
//$result_json = getMsg($get_group_msg_url);
//$result_arr = json_decode($result_json, true);
//p($result_arr);
$get_all_openids_url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".ACCESS_TOKEN."&next_openid=";

$result_json = file_get_contents($get_all_openids_url);
p($result_json);
p(json_decode($result_json, true));
