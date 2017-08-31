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
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      	//extract post data
             
      $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
      $fromUsername = $postObj->FromUserName;  //用户的openid ，不是唯一的，相同的用户关注不同的公众号后，获取的openid是不同的
      $toUsername = $postObj->ToUserName; //发送方微信号（来自用户 故为openid）
      $keyword = trim($postObj->Content); //用户发送的消息内容
      $MsgType = $postObj->MsgType; //消息的类型为"text"，微信会根据用户发送不同消息自动识别返回给BAE不同值(text, image, event, voice, video,location)
      $MsgId  = $postObj->MsgId;   //消息内容的随机id		
      $CreateTime = intval($postObj->CreateTime); //消息的创建时间
      
     //$formTime = date("Y-m-d H:i:s", $CreateTime); //将时间戳转换为具体的日期

      $textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
				</xml>";   
          		
          		//查看消息内容
          		$msg  = "开发者id: ".$toUsername."\n";
          		$msg .= "用户id: ".$fromUsername."\n";
          		$msg .= "消息id: ".$MsgId."\n";
          		$msg .= "消息发送过来的时间戳：".$CreateTime."\n";
          		$msg .= "消息类型: ".$MsgType."\n";
          		$msg .= "消息内容: ".$keyword."\n\n";    
          	//	$msg .= "消息发生的具体时间：".$formTime."\n";
          
          		$msgType = "text";
	            $contentStr = $msg;
              	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
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