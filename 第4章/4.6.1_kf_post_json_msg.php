<?php
require_once "lib.php";
define("APPID", "wx61882a060bc5ae02"); //APPID
define("APPSECRET", "8cf5662bb65df690890564ecf8318f24");//APPSECRET
/*$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET; //获取ACCESS_TOKEN请求的URL地址；
$res = file_get_contents($token_access_url);
$result = json_decode($res,true);//将获取的返回Json值转换为数组格式
$access_token = $result['access_token'];//将获取的access_token保存到临时变量中。*/
$access_token = "V3uZrpM7QRL06-NnfYgK9eBx5-c1yXfuw2_uO35CRvpZVRBDrGt5X6lzrY0_FVL_LK8Hktd42zQK_BvrWPEYvbzIao4_1mI708RF0a9PC-6RR99mhNNk-37PjFKiOPY-xBx8-PXn9GUjNyDEZ40QCg";
$send_msg_url ="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
$openid = "o6Unjt2jQ49UywtBTLx2MBwui4BY";
$post_json_data = '{"touser":"o6Unjt2jQ49UywtBTLx2MBwui4BY","msgtype":"text","text":{"content":"Hello World"}}';
$result = postMsg($send_msg_url, $post_json_data);
p($result);
