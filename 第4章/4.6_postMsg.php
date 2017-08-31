<?php
//推送客服消息
require_once "lib.php";

//肉盾
define("APPID", "wx5dcde27cde9b0e52"); //APPID
define("APPSECRET", "692034a27a5fe9ccb89ae59aa5a8563b");//APPSECRET

$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET; //获取ACCESS_TOKEN请求的URL地址；
$res = file_get_contents($token_access_url);
$result = json_decode($res,true);//将获取的返回Json值转换为数组格式
$access_token = $result['access_token'];//将获取的access_token保存到临时变量中。*/
//$access_token = "SzEp8XL7MPZ_bQqEUWKwKUZOtRMOEl_-5dQVrBjLtnp21jsavicbDKQuQltydfsgRU9subYquWGiqMsgTzaiO5vuTsijxtW27G2SCjg89CHtPaVJs1J0LRBQhe5jaj105BBMDZ9Z_fCeqBNGZTN6hA";
echo $access_token;


$send_msg_url ="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token; //客服消息POST提交的URL地址
define("SENDMSGURL", $send_msg_url);

$openid = "o-oGKjjCy11a8_h4od-Jwk3iHbP0"; //肉盾howaichun的openid
define("OPENID", $openid);



$arr = array(
  "articles" => array(
    array(
            "title"=>urlencode("新年快乐!!"),
        "description"=>urlencode("Is Really A Happy Day"),
         "url"=>urlencode("http://www.jiaofeiyi.net/images/joomlart/ja_brisk/avt-3.jpg"),
              "picurl"=>urlencode("http://www.jiaofeiyi.net/images/joomlart/ja_brisk/avt-3.jpg")
        ),
    array(
            "title"=>urlencode("Happy New Year!!"),
        "description"=>urlencode("Is Really A Happy Day"),
          "url"=>urlencode("http://www.jiaofeiyi.net/images/joomlart/ja_brisk/avt-3.jpg"),
              "picurl"=>urlencode("http://www.jiaofeiyi.net/images/joomlart/ja_brisk/avt-3.jpg")
        )              
  )       
);
function postNewsMsgDeal($openid, $arr){ //1、news
     $msgType="news";
     $post_array_data = array(
        "touser"=>$openid,
          "msgtype"=>$msgType,
          $msgType=>$arr
      );
     $json = urldecode(json_encode($post_array_data));
     $result = postMsg(SENDMSGURL, $json);
     return $result;  
}
//$result = postNewsMsgDeal(OPENID, $arr);
//p($result);


/*
* @params $openid  消息推送的微信用户的openid
* @params $msgType 消息类型  这里为“mesic”文本消息类型
* @params $arr     音乐消息的内容 
*/
$arr = array(  //制取存储的数据
  "title"=>urlencode("测试歌曲"),
  "description"=>urlencode("歌曲描述"),
  "musicurl"=>urlencode("http://0.terminal.duapp.com/Beyond.mp3"),
  "hqmusicurl"=>urlencode("http://0.terminal.duapp.com/Beyond.mp3"),
  "thumb_media_id"=>"zy2EJ8wrYX7rzMcJmqDQ-LDkAhP-bBdMsefU0qKnEVWIi0ku6MOEIrRu-iQjh6aw"

);
function postMusicMsgDeal($openid, $arr, $msgType="music"){ //2、music
   $post_array_data = array(
        "touser"=>$openid,
          "msgtype"=>$msgType,
          $msgType=>$arr
           );
  //p($post_array_data);
    $json = urldecode(json_encode($post_array_data));
    $result = postMsg(SENDMSGURL, $json);
    return $result;   
}
//$result = postMusicMsgDeal(OPENID, $arr);
//p($result);


/*
* @params $openid  消息推送的微信用户的openid
* @params $msgType 消息类型  这里为“text”文本消息类型
* @params $content  文本消息的内容 
*/
function postTextMsgDeal($openid, $content, $msgType="text"){  //3、text 
    $content = urlencode(trim($content)); 
    $post_array_data = array( "touser"=> $openid, "msgtype"=>$msgType, $msgType=>array("content"=>$content) );
      $post_json_data = urldecode(json_encode($post_array_data));     
    $result = postMsg(SENDMSGURL, $post_json_data);
      return $result;
}


//同意后获取授权
//$tmsg = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=http://3.terminal.duapp.com/book/4.8.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";

//直接获取授权
//$tmsg = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=http://3.terminal.duapp.com/book/4.8.php&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
//$result = postTextMsgDeal(OPENID, $tmsg);
//p($result);


/*
* @params $openid   消息推送的微信用户的openid
* @params $msgType  消息类型  voice/image
* @params $media_id 上传媒体文件时获取的media_id
*/
function post_IV_MsgDeal($openid, $msgType, $media_id){ //1、voice、2、image 
   $post_array_data = array( "touser"=> $openid, "msgtype"=>$msgType, $msgType=>array("media_id"=>$media_id) );
     $post_json_data = json_encode($post_array_data);
     p($post_json_data);
     $result = postMsg(SENDMSGURL, $post_json_data);
     return $result;
}


//$media_id = "ho6l1exNT4JV5fDadJJJbY51cAJllDsZsD3lmTP8RAFJA1xIZWTMpCyCf12_Pmb7"; //image
//$media_id = "wrCfMkVG9z_sZ7eKhAELkRYCYeMtI1wmX_FlMzxSxH8l1nR3SVSJQKcUhNczGNKN"; //voice
//$result = post_IV_MsgDeal(OPENID, "image", $media_id);
//$result = post_IV_MsgDeal($openid, "voice", "anbN4N-xPzL4SxcpKN7QCVYp6jYzew1aPfh8j4Byx1xWYhutFJH1nt1R-ie484Cv");
//p($result);


$arr = array(  
  "media_id"=>"9DI9eQnl4E32CK5ZopV_DwplBAxYeyVBxyoH2bvQDBitPQiM4tqCM8vvTIFuBbQt",
  //"media_id"=>"MmX0JV_ISJz_3J-EAkuKdEFnJyFyz4QATUZ7RMoW1fuEaiTdUbYi6hclXewV12gA",
  "title"=>urlencode("TITLE"),
  "description"=>urlencode("DESCRIPTION")
);
/*
* @params string $openid  用户的openid
* @params array  $arr     视频消息的相关内容
* @params string $msgType 标识所要推送的消息为视频消息
*/
function postVideoMsgDeal($openid, $arr){ //6、video
   $msgType="video"; //post 的消息类型为video
   $post_array_data = array(
        "touser"=>$openid,
          "msgtype"=>$msgType,
          $msgType=>$arr
       );
    $json = urldecode(json_encode($post_array_data));
    $result = postMsg(SENDMSGURL, $json);
    return $result;    
}

//$result = postVideoMsgDeal(OPENID, $arr);
//p($result);