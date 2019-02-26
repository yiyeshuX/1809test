<?php
header('Content-Type: text');

define('TOKEN', 'weixin');
//1. 实例化对象
$wechatObj = new WechatAPI();
// 2.调用方法

if (isset($_GET['echostr'])) {
	$wechatObj->validSignature();
} else {
	$wechatObj->reponseMsg();
}
//3.接受消息并返回消息

class WechatAPI{
	/**
	 * 验证请求来自微信服务器
	 * @return String echostr字符串(成功)
	 * 返回给微信服务器
	 */
	public function validSignature(){
		$echoStr = $_GET['echostr'];
		if ($this->isCheckSignature()) {
			echo  $echoStr;
			exit;	
			 // *1)将token、timestamp、nonce三个参数进行字典序排序
		}
	}
	/**
	 * 生成加密前面字符串,并行性验证,返回true/false
	 * @return boolean 
	 */				
	private function isCheckSignature(){
		$token		 	= 	TOKEN;
		$timestamp	 	= 	$_GET['timestamp'];
		$nonce 			= 	$_GET['nonce'];
		$signature      =	$_GET['signature'];
		$tmpArray 		= 	[$token,$timestamp,$nonce];
		sort($tmpArray);
		 // *2）将三个参数字符串拼接成一个字符串进行sha1加密 
	 	$tmpStr = implode($tmpArray);
	 	$tmpStr = sha1($tmpStr);

	 	// *3）开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
	
	 	if ($tmpStr == $signature) {
	 		return true;
	 	} else {
	 		return false;
	 	}
	}
	/**
	 * 接受用户消息,返回消息(XML字符串)
	 * @return String XML字符串
	 */
	public function reponseMsg()
	{	//1接受
		$xmlStr = file_get_contents('php://input');
		if (!empty($xmlStr)) {
		//2转换为对象
			$xmlObj = simplexml_load_string($xmlStr,"SimpleXMLElement",LIBXML_NOCDATA);
					$type = $xmlObj->MsgType;
				switch ($type) {
					case 'text':
						$result    = $this->receiveTextMsg($xmlObj);
						break;
					case 'image':
						$result    = $this->receiveImageMsg($xmlObj);
						break;
					default:
						$result  = $this->transmitText($xmlObj,"更多内容请查看<a href='https://baike.baidu.com/item/%E4%B8%80%E9%A1%B5%E4%B9%A6/10870163?fr=aladdin'>查看更多</a>");
						break;
				}

				echo $result;
					}
		
	}

	/**
	 * 判断用户输入文本消息内容,返回一个拼接好的XML字符串
	 * 
	 * @return [type]        [description]
	 */
	public function receiveTextMsg($xmlObj)
	{
		$keyword  = trim($xmlObj->Content);
		if ($keyword=='图文') {

			$newsArray = [
							['Title'=>'百世经纶','Description'=>'公认的中原第一强者。','PicUrl'=>'http://1.yiyeshu.applinzi.com/timg6.jpg','Url'=>'https://baike.baidu.com/item/%E4%B8%80%E9%A1%B5%E4%B9%A6/10870163?fr=aladdin'],
							['Title'=>'百世经纶','Description'=>'公认的中原第一强者。','PicUrl'=>'http://1.yiyeshu.applinzi.com/timg6.jpg','Url'=>'https://baike.baidu.com/item/%E4%B8%80%E9%A1%B5%E4%B9%A6/10870163?fr=aladdin']
						];

			$result =$this->transmitNews($xmlObj,$newsArray);

		} else {
			$content   = '你发送的是文本消息,输入的是:'.$xmlObj->Content; 
			$result =$this->transmitText($xmlObj,$content);

		}
		return $result;
	}



		/**
	 * 判断用户输入图片消息内容,返回一个拼接好的XML字符串
	 * 
	 * @return [type]        [description]
	 */
	public function receiveImageMsg($xmlObj)
	{
		$content   = '你发送的是图片,图片地址是:'.$xmlObj->PicUrl; 
		
		$result =$this->transmitText($xmlObj,$content);
		
		return $result;
	}



	/**
	 * 拼接返回的文本消息XML字符串
	 * @return String
	 */
	private function transmitText($xmlObj,$content)
	{
		
					$resultStr = '
					<xml><ToUserName><![CDATA[%s]]></ToUserName> <FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content></xml>';
 						
 						$resultStr =  sprintf($resultStr,$xmlObj->FromUserName,$xmlObj->ToUserName,time(),$content);
 						
 						return $resultStr;
	}


	/**
	 * 给定二维数组,根据数组元素的个数,拼接返回图文消息XML字符串
	 * 
	 * @param SimpleXMLElement $xmlObj
	 * @param Array $newsArray
	 * 
	 * @return String XML字符串
	 */
	private function transmitNews($xmlObj,$newsArray)
	{
		if (!is_array($newsArray)) {
			retuan;
		}

			$itemStr = '
					<item>
						<Title><![CDATA[%s]]></Title>
					 	<Description><![CDATA[%s]]></Description>
					 	<PicUrl><![CDATA[%s]]></PicUrl>
					 	<Url><![CDATA[%s]]></Url>
					 </item>';

					 $tmpStr = '';
				foreach ($newsArray as  $itemArray) {
					$tmpStr.=sprintf(
										$itemStr,$itemArray['Title'],
									 			$itemArray['Description'],
												$itemArray['PicUrl'],
												$itemArray['Url']);
				}
				$leftStr = "
				<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[news]]></MsgType><ArticleCount>%s</ArticleCount><Articles>$tmpStr</Articles></xml>";
				
					$result = sprintf($leftStr,$xmlObj->FromUserName,$xmlObj->ToUserName,time(),count($newsArray));

 						
	}
}


