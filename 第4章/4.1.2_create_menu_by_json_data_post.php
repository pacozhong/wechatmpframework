<?php
//4.1.2 创建自定义菜单
//header("Content-type: text/xml; charset=utf-8");
require_once "lib.php"; 
$result = getMsg($token_access_url);
$arr_result = json_decode($result, true);
define("ACCESS_TOKEN", $arr_result['access_token']); //定义为全局，便于使用*/
$make_menu_url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".ACCESS_TOKEN; //
$menuTpl ='{
     "button":[
     {	
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "type":"click",
           "name":"歌手简介",
           "key":"V1001_TODAY_SINGER"
      },
      {
           "name":"菜单",
           "sub_button":[
           {	
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
               "type":"view",
               "name":"视频",
               "url":"http://v.qq.com/"
            },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }';
p($menuTpl);
$result = postMsg($make_menu_url, $menuTpl);
$demo = json_decode($result, true);
p($demo);


