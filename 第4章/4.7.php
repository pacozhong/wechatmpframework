<?php
//创建二维码
require_once "lib.php";
require_once "downloadfile.php";

//肉盾
define("APPID", "wx5dcde27cde9b0e52"); //APPID
define("APPSECRET", "692034a27a5fe9ccb89ae59aa5a8563b");//APPSECRET

$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET; //获取ACCESS_TOKEN请求的URL地址；
$res = file_get_contents($token_access_url);
$result = json_decode($res,true);//将获取的返回Json值转换为数组格式
$access_token = $result['access_token'];//将获取的access_token保存到临时变量中。*/
//$access_token = "r9IM7qFARYaY7gYOPQLHujhnAkUFS4aqxhMuFao_icIHqgluuCR1Tgnq2S3BIqhlXp1pLY705xsIFhyMZeBAEqIKez9z18ivFT1aLFF40xQV6fJq6ngvwGA0C5ZEcc5UxQv_l4Szr35mrZS01yZUag";
echo $access_token;
define("ACCESS_TOKEN", $access_token);
$get_msg_url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".ACCESS_TOKEN;


$rand_area = rand(1, 1000);
$expire_seconds = rand(1, 300);

//创建临时的ticket
$post_er_array = array(
			"expire_seconds" => $expire_seconds, //临时二维码有效时间
			"action_name"=>"QR_SCENE",
			"action_info"=>array(
				"scene"=>array(
					"scene_id"=> $expire_seconds
				)
			)
		);
$post_json = json_encode($post_er_array);
//$post_json = '{"expire_seconds": 1800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}';


//创建永久的ticket
/*$post_er_array = array(
			"action_name"=>"QR_LIMIT_SCENE",
			"action_info"=>array(
				"scene"=>array(
					"scene_id"=> $rand_area
				)
			)
		);
$post_json = json_encode($post_er_array);
p($post_json);*/
//$post_json = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}';

$result = postMsg($get_msg_url, $post_json);

$arr = json_decode($result, true);  //获取ticket的值
//p($arr);
$ticket = $arr["ticket"];
p($ticket);

define("TICKET", urlencode($ticket));
//拉取二维码的URL地址
$get_erweima_url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".TICKET;
p($get_erweima_url);  //将这里的地址链接直接黏贴到浏览器地址栏访问即可查看到生成的二维码图片


//echo downloadfile($get_erweima_url); 开启即可下载生成的二维码图片




