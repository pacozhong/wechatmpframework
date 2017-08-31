<?php
//点击菜单事件（此文件放入BAE/SAE 服务器使用）
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
	    $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];             
      $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
     
      $fromUsername = $postObj->FromUserName;  //用户的openid ，不是唯一的，相同的用户关注不同的公众号后，获取的openid是不同的
      $toUsername = $postObj->ToUserName; //发送方微信号（来自用户 故为openid）
	    $MsgType = $postObj->MsgType; //事件消息的类型为"event",根据据用户发送不同消息自动识别返回给BAE不同值(text, image, event, voice, video,location)
      $MsgId  = $postObj->MsgId;   //事件消息内容的随机id		
      $Event = $postObj->Event; //事件类型 click
      $EventKey = $postObj->EventKey; //事件KEY值，与自定义菜单接口中KEY值对应
      $CreateTime = intval($postObj->CreateTime); //消息创建时间戳,根据这个时间戳可以格式化为具体的日期
	    $formTime = date("Y-m-d H:i:s", $CreateTime);	
      
      //接受到的事件消息的所有数据字段合成
      $msg  = "开发者id: ".$toUsername."\n";
      $msg .= "用户id: ".$fromUsername."\n";
      $msg .= "事件消息id: ".$MsgId."\n";
      $msg .= "事件消息类型: ".$MsgType."\n";
      $msg .= "事件类型: ".$Event."\n";
      $msg .= "事件KEY值，与自定义菜单接口中KEY值对应： ".$EventKey."\n";
	    $msg .= "事件发送过来的时间戳：".$CreateTime."\n";      
      $msg .= "消息发生具体时间：".$formTime."\n";
      
      $textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
				 </xml>";  
      
      $contentStr = $msg;
      $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), "text", $contentStr);
      echo $resultStr;

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