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
	
      $CreateTime = intval($postObj->CreateTime); //消息的创建时间
      $formTime = date("Y-m-d H:i:s", $CreateTime); //将时间戳转换为具体的日期

      $textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
				</xml>";   
          
          		$msgType = "text";
	            $contentStr = "欢迎您，关注我。";
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