<?php
//通过CURL上传文件到微信服务器中
require_once "lib.php"; //包含代码清单4.3函数
$media_type ="image"; //设置上传image媒体文件类型
$url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=".ACCESS_TOKEN."&type=".$media_type;
 $post_data = array (  	"media" => "@D:/1.jpg" ); 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POST, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); 
$output = curl_exec($ch); 
curl_close($ch); 
echo $output;
p($output);
