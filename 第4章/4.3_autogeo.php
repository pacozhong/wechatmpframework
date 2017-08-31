<?php
/*自动提供用户地理位置信息触发event事件（此文件放入BAE/SAE 服务器使用）*/
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
	  $MsgType = $postObj->MsgType; //消息的类型为"event"，微信会根据用户发送不同消息自动识别返回给BAE不同值(text, image, event, voice, video,location)
      $MsgId  = $postObj->MsgId;   //消息内容的随机id		
      $CreateTime = intval($postObj->CreateTime); //消息创建时间戳
      $Latitude = $postObj->Latitude; //地理位置的纬度
      $Longitude = $postObj->Longitude; //地理位置的经度
      $Precision = $postObj->Precision; //	 地理位置精度
      $Event = $postObj->Event; //事件类型，LOCATION
      
      $formTime = date("Y-m-d H:i:s", $CreateTime); //将时间戳转换为具体的日期
      /* 
	   * 下列是合成所有接受到图片消息的数据字段
	   * 说明： 1、点“.”是PHP中的连接运算符；  2、"\n" 是换行符。
	   */
      //接受到的地理位置消息的所有数据字段合成
      $msg  = "开发者id: ".$toUsername."\n";
      $msg .= "用户id: ".$fromUsername."\n";
      $msg .= "地理位置消息id: ".$MsgId."\n";
      $msg .= "地理位置消息类型: ".$MsgType."\n";
      $msg .= "地理位置的纬度: ".$Latitude."\n";
      $msg .= "地理位置的经度: ".$Longitude."\n";
      $msg .= "地理位置精度: ".$Precision."\n";
      $msg .= "事件类型: ".$Event."\n";     
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