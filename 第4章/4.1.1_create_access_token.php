<?php
//4.1.1 创建access_token
define("APPID", "wx61882a060bc5ae02"); //APPID
define("APPSECRET", "8cf5662bb65df690890564ecf8318f24");//APPSECRET
$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET; //获取ACCESS_TOKEN请求的URL地址；
$res = file_get_contents($token_access_url);
$result = json_decode($res,true);//将获取的返回Json值转换为数组格式
$access_token = $result['access_token'];//将获取的access_token保存到临时变量中。
echo $access_token; //输出获取到的Access_token的值，*/
