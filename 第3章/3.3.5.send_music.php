<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "api");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();

class wechatCallbackapiTest
{
  	public function valid(){     
        if(isset($_GET['mydebug'])){ //处理测试用数据 
          	$result = isset($_GET['t'])?$_GET['mydebug']:'';
            echo $result;
		}else{  //处理 微信客户端提交的数据值
          	if($this->checkSignature()){
               $echoStr = $_GET["echostr"];
               echo $echoStr;
               $this->responseMsg(); 
			   exit;
			}
		}
    }
 	
    public function responseMsg()
    {
      //接受消息开始
	  $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//获取微信服务器提交过来的数据
      $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);//将获取的处理处理
      
      $fromUsername = $postObj->FromUserName;  //用户的openid ，不是唯一的，相同的用户关注不同的公众号后，获取的openid是不同的
      $toUsername = $postObj->ToUserName; //发送方微信号（来自用户 故为openid）
      
      //回复音乐消息
      $time = time(); //回复图片消息的时间戳  
 	  $musicTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[%s]]></MsgType>
			<Music>
				<Title><![CDATA[%s]]></Title>
				<Description><![CDATA[%s]]></Description>
				<MusicUrl><![CDATA[%s]]></MusicUrl>
				<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>				
			</Music>
		</xml>";
      //<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
         $msgType = "music"; //表音乐消息类型
		 $Title = "测试用音乐标题"; //音乐标题
		 $Description = "测试用音乐描述";//音乐描述
      	 $MusicUrl = $HQMusicUrl = "http://0.terminal.duapp.com/Beyond.mp3";
		 $resultStr = sprintf($musicTpl, $fromUsername, $toUsername, $time, $msgType, $Title, $Description, $MusicUrl, $HQMusicUrl);//经过sprintf处理过后，*/
        echo $resultStr;
	   exit;
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>