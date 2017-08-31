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
   		                 
	//回复视频消息开始
	  $time = time(); //回复视频消息的当前时间的时间戳  
      $videoTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Video>
			<MediaId><![CDATA[%s]]></MediaId>
			<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
		</Video> 
     </xml>";
 
         $msgType = "video"; //表视频消息类型
      	 $MediaId = "gMQSfwGuBduslCJCRKN9ctkRuDX-JMR5KMRDC_FFveG-73657IuicPl1-TUM1Za4"; //媒体的mediaId
      	 $ThumbMediaId = "RG-MGRendFYoglpvU-mycnbVUMNfu2YMlz7BFlquB8xdUmHEt98q7EeqiVQCXLqF"; //媒体的ThumbMediaId
		 $Title = "测试用视频标题"; //视频标题
		 $Description = "测试用视频描述";//视频描述
         $resultStr = sprintf($videoTpl, $fromUsername, $toUsername, $time, $msgType, $MediaId, $ThumbMediaId);//经过sprintf处理过后，*/
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