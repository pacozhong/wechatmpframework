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
   		
      $time = time(); //回复视频消息的当前时间的时间戳  
	

                 
	//回复新闻消息开始
		$nMsg = 4;
		$newsTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[news]]></MsgType>
		<ArticleCount><![CDATA[$nMsg]]></ArticleCount>
		<Articles>
		<item>
		<Title><![CDATA[欢迎进入缴费易活动周]]></Title>
		<Description><![CDATA[欢迎进入缴费易11111]]></Description>
		<PicUrl><![CDATA[http://www.jiaofeiyi.net/images/joomlart/ja_brisk/avt-5.jpg]]></PicUrl>
		<Url><![CDATA[$from_imgUrl]]></Url>
		</item>
		<item>
		<Title><![CDATA[欢迎进入缴费易活动周]]></Title>
		<Description><![CDATA[description1]]></Description>
		<PicUrl><![CDATA[http://www.jiaofeiyi.net/images/joomlart/ja_brisk/avt-3.jpg]]></PicUrl>
		<Url><![CDATA[$from_imgUrl]]></Url>
		</item>
		<item>
		<Title><![CDATA[活动地点]]></Title>
		<Description><![CDATA[description2]]></Description>
		<PicUrl><![CDATA[http://www.jiaofeiyi.net/images/joomlart/ja_brisk/avt-5.jpg]]></PicUrl>
		<Url><![CDATA[$from_imgUrl]]></Url>
		</item>
		<item>
		<Title><![CDATA[精彩回顾]]></Title>
		<Description><![CDATA[description3]]></Description>
		<PicUrl><![CDATA[$from_imgUrl]]></PicUrl>
		<Url><![CDATA[$from_imgUrl]]></Url>
		</item>
		</Articles>
		<FuncFlag>0</FuncFlag>
		</xml>";
		 
		//$msgType = "text";
		$msgType= "news";
		$contentStr = $from_imgUrl;
		$resultStr = sprintf($newsTpl, $fromUsername, $toUsername, time(), $msgType);
  
 
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