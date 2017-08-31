<?php
//4.1.4 自定义菜单查询
//header("Content-type: text/xml; charset=utf-8");
require_once "lib.php"; 
$result = getMsg($token_access_url);
$arr_result = json_decode($result, true);

define("ACCESS_TOKEN", $arr_result['access_token']); //定义为全局，便于使用*/
$make_menu_url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".ACCESS_TOKEN; //获取菜单抽取URL地址

$menu_json = file_get_contents($make_menu_url);
echo $menu_json;


$menu_arr = json_decode($menu_json, true);
echo "<pre>";
var_dump($menu_arr);
echo "</pre>";



