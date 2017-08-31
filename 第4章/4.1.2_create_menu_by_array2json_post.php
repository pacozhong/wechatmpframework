<?php
//4.1.2 创建自定义菜单
//header("Content-type: text/xml; charset=utf-8");
require_once "lib.php"; 
$result = getMsg($token_access_url);
$arr_result = json_decode($result, true);
define("ACCESS_TOKEN", $arr_result['access_token']); //定义为全局，便于使用*/
$make_menu_url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".ACCESS_TOKEN; //
p(ACCESS_TOKEN);
$menuTpl=array(
	   		"button"=>array(
						      array(
						        "type"=>"click",
						        "name"=>urlencode("今日歌曲"),
						        "key"=> "V1001_TODAY_MUSIC"
						      ),
						      array(
						        "type"=>"click",
						        "name"=>urlencode("歌手简介"),
						        "key"=>"V1001_TODAY_SINGER"
						      ),
	  						  array(
						        "name"=>urlencode("菜单"),
	     						"sub_button"=>array(
								        array(
							        		"type"=>"view",
									        "name"=>urlencode("搜索"),
									        "url"=> urlencode("http://www.soso.com/")
							        	),       
								        array(
										    "type"=>"view",
									        "name"=>urlencode("视频"),
									        "url"=>urlencode("http://v.qq.com/")
								        ),
								        array(
										    "type"=>"click",
									        "name"=>urlencode("赞一下我们"),
									        "key"=>"V1001_GOOD"
							        	)
	    						)
	    					  )
			)
		);



$menuTpl_json = urldecode(json_encode($menuTpl));
p($menuTpl_json);
     
$result = postMsg($make_menu_url, $menuTpl_json);
$demo = json_decode($result, true);
p($demo);

