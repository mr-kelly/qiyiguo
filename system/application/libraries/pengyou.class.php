<?php
/**
 * PHP SDK for pengyou Open API
 *
 * @version 1.0.1
 * @author dev.opensns@qq.com
 * @copyright © 2010, Tencent Corporation. All rights reserved.
 */
 
/**
 * 如果您的 PHP 没有安装 cURL 扩展，请先安装 
 */
if (!function_exists('curl_init'))
{
	throw new Exception('Pengyou API needs the cURL PHP extension.');
}

/**
 * 如果您的 PHP 不支持JSON，请升级到 PHP 5.2.x 以上版本
 */
if (!function_exists('json_decode'))
{
	throw new Exception('Pengyou API needs the JSON PHP extension.');
}

/**
 * 错误码定义
 */
define('PYO_ERROR_REQUIRED_PARAMETER_EMPTY', 2001); // 参数为空
define('PYO_ERROR_REQUIRED_PARAMETER_INVALID', 2002); // 参数格式错误
define('PYO_ERROR_RESPONSE_DATA_INVALID', 2003); // 返回包格式错误
define('PYO_ERROR_CURL', 3000); // 网络错误, 偏移量3000, 详见 http://curl.haxx.se/libcurl/c/libcurl-errors.html

/**
 * 提供访问腾讯朋友社区（QQ校友） OpenAPI 的接口
 */
class Pengyou
{
	/**
	 * SDK 版本号
	 */
	const VERSION  = '1.0.1';

	/**
	 * 应用的唯一ID
	 */
	private $appId;

	/**
	 * 应用的密钥，用于验证应用的合法性
	 */
	private $appKey;

	/**
	 * 应用的英文名(唯一)
	 */
	private $appName;

	/**
	 * Pengyou OpenAPI 服务器的域名
	 */
	private $serverName = 'http://openapi.pengyou.qq.com';

	/**
	 * 构造函数，初始化一个朋友社区（QQ校友）应用
	 *
	 * @param int $appId 应用的ID
	 * @param string $appKey 应用的密钥
	 * @param string $appName 应用的英文名
	 */
	function __construct($appId, $appKey, $appName)
	{
		$this->setAppId($appId);
		$this->setAppKey($appKey);
		$this->setAppName($appName);
	}
	
	/**
	 * 设置应用ID
	 *
	 * @param int $appId 应用的唯一ID
	 */
	public function setAppId($appId)
	{
		$this->appId = $appId;
	}

	/**
	 * 获取应用ID
	 *
	 * @return int 应用的唯一ID
	 */
	public function getAppId()
	{
		return $this->appId;
	}

	/**
	 * 设置应用密钥
	 *
	 * @param string $appKey 应用密钥
	 */
	public function setAppKey($appKey)
	{
		$this->appKey = $appKey;
	}

	/**
	 * 获取应用密钥
	 *
	 * @return string 应用密钥
	 */
	public function getAppKey()
	{
		return $this->appKey;
	}

	/**
	 * 设置应用英文名
	 *
	 * @param string $appName 应用的英文名
	 */
	public function setAppName($appName)
	{
		$this->appName = $appName;
	}

	/**
	 * 获取应用英文名
	 *
	 * @return string 应用的英文名
	 */
	public function getAppName()
	{
		return $this->appName;
	}

	/**
	 * 设置API服务器的域名
	 *
	 * @param string $server_name  Pengyou OpenAPI 服务器的域名
	 */
	public function setServerName($server_name)
	{
		$this->serverName = $server_name;
	}

	/**
	 * 获取API服务器的域名
	 *
	 * @return string  Pengyou OpenAPI 服务器的域名
	 */
	public function getServerName()
	{
		return $this->serverName;
	}

	/**
	 * 执行API调用，返回结果数组
	 *
	 * @param array $method 调用的API方法
	 * @param array $params 调用API时带的参数
	 * @return array 结果数组
	 */
	public function api($method, $params)
	{
		// 检查 openid 是否为空
		if (!isset($params['openid']) || empty($params['openid']))
		{
			return array(
				'ret' => PYO_ERROR_REQUIRED_PARAMETER_EMPTY,
				'msg' => 'openid is empty');
		}
		// 检查 openkey 是否为空
		if (!isset($params['openkey']) || empty($params['openkey']))
		{
			return array(
				'ret' => PYO_ERROR_REQUIRED_PARAMETER_EMPTY,
				'msg' => 'openkey is empty');
		}
		// 检查 openid 是否合法
		if (!self::isOpenId($params['openid']))
		{
			return array(
				'ret' => PYO_ERROR_REQUIRED_PARAMETER_INVALID,
				'msg' => 'openid is invalid');
		}
		
		// 添加一些参数
		$params['appid'] = $this->getAppId();
		$params['appkey'] = $this->getAppKey();
		$params['ref'] = $this->getAppName();
		
		// 得到 OpenAPI 的地址
		$url = $this->getApiUrl($method);
		
		return $this->makeRequest($url, $params);
	}

	/**
	 * 执行一个 HTTP POST 请求, 返回结果数组。可能发生cURL错误
	 *
	 * @param string $url 执行请求的URL
	 * @param array $params 表单参数
	 * @return array 结果数组
	 */
	private function makeRequest($url, $params)
	{
		$ch = curl_init();
		$queryList = http_build_query($params, null, '&');

		$opts = array();
		$opts[CURLOPT_RETURNTRANSFER] = true;
		$opts[CURLOPT_TIMEOUT] = 30;
		$opts[CURLOPT_POST] = 1;
		$opts[CURLOPT_POSTFIELDS] = $queryList;
		$opts[CURLOPT_USERAGENT] = 'pengyou-php-1.0';
		$opts[CURLOPT_URL] = $url;

		curl_setopt_array($ch, $opts);
		
		$result = curl_exec($ch);

		if (false === $result)
		{
			// cURL 网络错误, 返回错误码为 cURL 错误码加偏移量
			// 详见 http://curl.haxx.se/libcurl/c/libcurl-errors.html
			$err = array(
				'ret' => PYO_ERROR_CURL + curl_errno($ch),
				'msg' => curl_error($ch));
			curl_close($ch);
			return $err;
		}
		curl_close($ch);
		
		$result_array = json_decode($result, true);
		
		// 远程返回的不是 json 格式, 说明返回包有问题
		if (is_null($result_array)) {
			return array(
				'ret' => PYO_ERROR_RESPONSE_DATA_INVALID,
				'msg' => $result);
		}
		return $result_array;
	}

	/**
	 * 根据要调用的方法返回 API URL
	 *
	 * @param string $method API方法名
	 * @return string API URL
	 */
	private function getApiUrl($method)
	{
		return $this->getServerName() . '/cgi-bin/xyoapp/' . $method . '.cgi';
	}

	/**
	 * 检查 openid 的格式
	 *
	 * @param string $openid openid
	 * @return bool (true|false)
	 */
	private static function isOpenId($openid)
	{
		return (0 == preg_match('/^[0-9a-fA-F]{32}$/', $openid)) ? false : true;
	}
	
	###############################################################################
	#                        以下是用户需要调用的函数接口
	###############################################################################

	/**
	 * 返回当前登录用户信息
	 * 
	 * @param string $openid openid
	 * @param string $openkey openkey
	 * @return array
			- ret : 返回码 (0:正确返回, [1000,~]错误)
			- nickname : 昵称
			- gender : 性别
			- province : 省
			- city : 市
			- figureurl : 头像url
			- is_vip : 是否黄钻用户 (true|false)
			- is_year_vip : 是否年费黄钻(如果is_vip为false, 那is_year_vip一定是false)
			- vip_level : 黄钻等级(如果是黄钻用户才返回此字段)
	 */
	public function getUserInfo($openid, $openkey)
	{
		$result = $this->api('xyoapp_get_userinfo',
						array(
							'openid' => $openid,
							'openkey' => $openkey
						)
					);
		return $result;
	}

	/**
	 * 验证是否好友(验证 fopenid 是否是 openid 的好友)
	 * 
	 * @param string $openid openid
	 * @param string $openkey openkey
	 * @param array $input_array
			- fopenid : string 待验证用户的openid
	 * @return array
	 		- ret : 返回码 (0:正确返回, [1000,~]错误)
			- isFriend : 是否为好友(0:不是好友; 1:是好友; 2:是同班同学)
	 */
	public function isFriend($openid, $openkey, $input_array)
	{
		if (!self::isOpenId($input_array['fopenid']))
		{
			return array(
				'ret' => PYO_ERROR_REQUIRED_PARAMETER_INVALID,
				'msg' => 'fopenid is invalid');
		}
		
		$result = $this->api('xyoapp_get_isrelation',
						array(
							'openid' => $openid,
							'openkey' => $openkey,
							'fopenid' => $input_array['fopenid']
						)
					);
		return $result;
	}

	/**
	 * 获取好友列表
	 *
	 * @param string $openid openid
	 * @param string $openkey openkey
	 * @param array $input_array
			- infoed : int 是否需要好友的详细信息(0:不需要;1:需要)
			- apped : int 对此应用的安装情况(-1:没有安装;1:安装了的;0:所有好友)
			- page : int 获取对应页码的好友列表，从1开始算起，每页是100个好友。(不传或者0：返回所有好友;>=1，返回对应页码的好友信息)
	 * @return array 好友关系链的数组
			- ret : 返回码 (0:正确返回; (0,1000):部分数据获取错误,相当于容错的返回; [1000,~]错误)
			- items : array 用户信息
				- openid : 好友QQ号码转化得到的id
				- nickname : 昵称(infoed==1时返回)
				- gender : 性别(infoed==1时返回)
				- figureurl : 头像url(infoed==1时返回)
	 */
	public function getFriendList($openid, $openkey, $input_array = array())
	{
		$result = $this->api('xyoapp_get_relationinfo',
						array_merge(
							array(
								'openid' => $openid,
								'openkey' => $openkey,
								'infoed' => 0,
								'apped' => 1,
								'page' => 0
							), $input_array
						)
					);
		return $result;
	}

	/**
	 * 批量获取用户详细信息
	 * 
	 * @param string $openid openid
	 * @param string $openkey openkey
	 * @param array $input_array
			- fopenids : array 需要获取数据的openid列表
	 * @return array 好友详细信息数组
			- ret : 返回码 (0:正确返回; (0,1000):部分数据获取错误,相当于容错的返回; [1000,~]错误)
			- items : array 用户信息
				- openid : 好友的 OPENID
				- nickname :昵称
				- gender : 性别
				- figureurl : 头像url
				- is_vip : 是否黄钻 (true:黄钻; false:普通用户)
				- is_year_vip : 是否年费黄钻 (is_vip为true才显示)
				- vip_level : 黄钻等级 (is_vip为true才显示)
	 */
	public function getMultiInfo($openid, $openkey, $input_array = array())
	{
		if (empty($input_array['fopenids']) || !is_array($input_array['fopenids']))
		{
			return array(
				'ret' => PYO_ERROR_REQUIRED_PARAMETER_EMPTY,
				'msg' => 'fopenids is empty');
		}
		
		$result = $this->api('xyoapp_multi_info',
						array(
							'openid' => $openid,
							'openkey' => $openkey,
							'fopenids' => implode('_', $input_array['fopenids'])
						)
					);
		return $result;
	}

	/**
	 * 验证登录用户是否安装了应用
	 * 
	 * @param string $openid openid
	 * @param string $openkey openkey
	 * @return array
	 		- ret : 返回码 (0:正确返回, [1000,~]错误)
			- setuped : 是否安装(0:没有安装;1:安装)
	 */
	public function isSetuped($openid, $openkey)
	{
		$result = $this->api('xyoapp_get_issetuped',
						array(
							'openid' => $openid,
							'openkey' => $openkey
						)
					);
		return $result;
	}

	/**
	 * 判断用户是否为黄钻
	 *
	 * @param string $openid openid
	 * @param string $openkey openkey
	 * @return array
	 		- ret : 返回码 (0:正确返回, [1000,~]错误)
			- is_vip : 是否黄钻 (true:黄钻; false:普通用户)
	 */
	public function isVip($openid, $openkey)
	{
		$result = $this->api('xyoapp_pay_showvip',
						array(
							'openid' => $openid,
							'openkey' => $openkey
						)
					);
		return $result;
	}

	/**
	 * 获取好友的签名信息
	 * 
	 * @param string $openid openid
	 * @param string $openkey openkey
	  * @param array $input_array
			- fopenids : array 需要获取数据的openid列表(一次最多20个)
	 * @return array 好友的签名信息
			- ret : 返回码 (0:正确返回; (0,1000):部分数据获取错误,相当于容错的返回; [1000,~]错误)
			- items : array 用户信息
				- openid: 好友QQ号码转化得到的id
				- content: 好友的校友心情内容
	 */
	public function getEmotion($openid, $openkey, $input_array)
	{
		if (empty($input_array['fopenids']) || !is_array($input_array['fopenids']))
		{
			return array(
				'ret' => PYO_ERROR_REQUIRED_PARAMETER_EMPTY,
				'msg' => 'fopenids is empty');
		}
		
		$result = $this->api('xyoapp_get_emotion',
						array(
							'openid' => $openid,
							'openkey' => $openkey,
							'fopenids' => implode('_', $input_array['fopenids'])
						)
					);
		return $result;
	}
}

//End of Script
