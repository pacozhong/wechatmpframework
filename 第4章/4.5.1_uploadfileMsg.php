<?php
/*上传/下载文件*/
require_once "lib.php";
//肉盾
define("APPID", "wx5dcde27cde9b0e52"); //APPID
define("APPSECRET", "692034a27a5fe9ccb89ae59aa5a8563b");//APPSECRET

$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET; //获取ACCESS_TOKEN请求的URL地址；
$res = file_get_contents($token_access_url);
$result = json_decode($res,true);//将获取的返回Json值转换为数组格式
$access_token = $result['access_token'];//将获取的access_token保存到临时变量中。*/
//$access_token = "t7-jhsJYGx6lzv_m_OQttNK2nOSf3icNc52_RVOA5VpVzc3Fr2Nu9OgRs9PZurjnWtZpsKNNQZC-EdEjOLLddxo5YTIyj_q8cNkUTkBaSrLchk3DRbrxI_C_0RWjsBWvkYreDyZsoovjjUEj3tDHGg";
define("ACCESS_TOKEN", $access_token);
//echo $access_token;

$media_type = "image";
$url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=".ACCESS_TOKEN."&type=".$media_type;
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
		<title>媒体上传</title>	
        <script type="text/javascript" charset="utf-8" src="./show/jquery-1.10.1.min.js"></script>
	</head>
	<body>
			<form action="<?php  echo $url; ?>" method="post" enctype="multipart/form-data">
				<p><input type="file" name="file" id="file" value=""></p>              	
              	<p><input type="submit" name="submit" value="提交"></p>
			</form>
	</body>
</html>





