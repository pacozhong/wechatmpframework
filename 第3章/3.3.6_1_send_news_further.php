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
      
      //图文消息只能够发送，不能够接受  count值最10
	$newsTpl = "<item>
			<Title><![CDATA[%s]]></Title> 
			<Description><![CDATA[%s]]></Description>
			<PicUrl><![CDATA[%s]]></PicUrl>
			<Url><![CDATA[%s]]></Url>
	</item>";
	
	//回复新闻消息开始
		$arr = array(
          			array(
        				"title"=> "缴费易活动周好礼送",
                      	"description"=>"缴费易活动周好礼送",
                      	"picurl" => "http://www.jiaofeiyi.net/images/joomlart/ja_brisk/avt-5.jpg",
        				//'url' => "http://www.jiaofeiyi.net"
                    ),
          			array(
        				"title"=> "【终端查询】\n在“公共服务”导航，选择“终端查询”后，直接回复地址或地理位置信息获取终端信息",
          				//"description"=>"【公共查询】自主研发的一站式自助缴费支付网络终端设备，兼具信息发布平台功能，是北京市政“三通工程”便民项目。“缴费...",
          				"picurl" => "http://www.jiaofeiyi.net/images/joomlart/ja_brisk/avt-2.jpg",
        				//'url' => "http://9.terminal.duapp.com/show/11.jpg"
                    ),
       
          			array(
                      	"title"=> "【智能客服】\n在“公共服务”导航，选择“智能客服”后，直接回复问题 或 问题关键字（多个关键字，请用空格隔开）",
          				//"description"=>"【智能客服】自主研发的一站式自助缴费支付网络终端设备，兼具信息发布平台功能，是北京市政“三通工程”便民项目。“缴费...",
          				"picurl" => "http://www.jiaofeiyi.net/images/joomlart/ja_brisk/avt-3.jpg",
        				//'url' => "http://9.terminal.duapp.com/show/11.jpg"
                    ), 
					array(
						"title"=> "【在线客服】\n咨询缴费易相关服务及业务，拨打热线  400-819-3377",
					  //"description"=>"【在线客服】自主研发的一站式自助缴费支付网络终端设备，兼具信息发布平台功能，是北京市政“三通工程”便民项目。“缴费...",
						"picurl" => "http://www.jiaofeiyi.net/livezilla/image.php?id=04&amp;type=inlay",
					),
					array(
						"title"=> "【天气查询】\n在“公共服务”导航，选择“城市天气”后，直接城市名称，获取天气信息",
						"description"=>"【天气查询】自主研发的一站式自端设备，兼具信息发布平台功能，是北京市政“三通工程”便民项目。“缴费...",
						"picurl" => "http://www.jiaofeiyi.net/images/joomlart/ja_brisk/aut-10.png",
					),
        		);
		 $num = count($arr);
         $string = "";
   			for($i=0; $i<$num; $i++){
          	 	 $string .= sprintf($newsTpl, $arr["$i"]["title"], $arr["$i"]["description"], $arr["$i"]["picurl"], $arr["$i"]["url"]);            
      		}
      		$newsTpl = '<xml>
								<ToUserName><![CDATA[%s]]></ToUserName>
								<FromUserName><![CDATA[%s]]></FromUserName>
								<CreateTime>%s</CreateTime>
								<MsgType><![CDATA[%s]]></MsgType>
								<ArticleCount><![CDATA[%s]]></ArticleCount>
								<Articles>'.$string.'</Articles>
						</xml>';
		   $msgType= "news";
        $resultStr .= sprintf($newsTpl, $fromUsername, $toUsername, time(), $msgType,  $num);
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