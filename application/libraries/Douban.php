<?php

	require_once('douban_oauth/doubanOAuth.php');
	
	// 将library设成 include_path
	set_include_path(  dirname(__FILE__) );
	
	//require_once('oauth-php/library/OAuthStore.php');
	//require_once('oauth-php/library/OAuthRequester.php');
	
	
	
	define( 'DOUBAN_KEY', '08c6bb357d29bc971a5431a0777d35c5');
	define( 'DOUBAN_SECRET', '067080ae0b102419' );
	
	define( 'DOUBAN_OAUTH_URL' , 'http://www.douban.com/service/auth');
	define( 'DOUBAN_REQUEST_TOKEN_URL',   DOUBAN_OAUTH_URL . '/request_token');
	define( 'DOUBAN_AUTHORIZE_URL', DOUBAN_OAUTH_URL . '/authorize');
	define( 'DOUBAN_ACCESS_TOKEN_URL', DOUBAN_OAUTH_URL . '/access_token');
	
// define("TWITTER_AUTHORIZE_URL", TWITTER_OAUTH_HOST . "/oauth/authorize");
// define("TWITTER_ACCESS_TOKEN_URL", TWITTER_OAUTH_HOST . "/oauth/access_token");
// define("TWITTER_PUBLIC_TIMELINE_API", TWITTER_OAUTH_HOST . "/statuses/public_timeline.json");
// define("TWITTER_UPDATE_STATUS_API", TWITTER_OAUTH_HOST . "/statuses/update.json");


	class Douban {
		function __construct() {
			$ci =& get_instance();
			
			//if ( !$ci->session->userdata('douban_access_token') ) {
				$this->douban_oauth = new DoubanOAuth( DOUBAN_KEY, DOUBAN_SECRET );
			//} else {
			
				// 如果session中有 douban_access_token, 获取通行客户端
			//	$douban_access_token = $ci->session->userdata('douban_access_token');
			//	$this->douban_oauth = new DoubanOAuth( DOUBAN_KEY, DOUBAN_SECRET, $douban_access_token['oauth_token'], $douban_access_token['oauth_token_secret'] );
				
			//}


			
			
		}
		
		
		/**
		 *	获取豆瓣客户端
		 */
		function getDouban() {
		
		}
		
		
		/**
		 *	获取指定用户的 豆瓣客户端~ ( 从数据库 )
		 */
		function getUserDouban( $user_id ) {
		
		}
		
		/**
		 *	获取request token
		 */
		function get_request_token() {
			$request_token =  $this->douban_oauth->getRequestToken();
			
			// 将token_secret 存入 session, 以备access token提取时使用
			$ci =& get_instance();
			$ci->session->set_userdata('douban_oauth_token_secret', $request_token['oauth_token_secret'] );
			
			
			
			return $request_token;
		}
		
		/**
		 *	获取Request Token
		 		然后获取用户授权 request token的页面
		 		
		 	$callback 用户授权后转到的页面
		 */
		function get_authorize_url( $callback='' ) {
			$request_token = $this->get_request_token();
			
			$url = $this->douban_oauth->getAuthorizeURL( $request_token['oauth_token'] );
			
			if ( !empty( $callback ) ) {
				$url .=  '&oauth_callback=' . $callback;
			}
			
			return $url;
		}
		
		
		function get_access_token( $oauth_token ) {  // $oauth_token -> string    oauth_token_secret从session获取
			$ci =& get_instance();
			
			$oauth_token_secret = $ci->session->userdata('douban_oauth_token_secret');
			
			

			// 关键，需要一个新的DoubanOAuth实例
			$new_douban_oauth  = new DoubanOAuth( DOUBAN_KEY, DOUBAN_SECRET, $oauth_token, $oauth_token_secret );
			
			
			$token_array = array(
				'oauth_token' => $oauth_token,
				'oauth_token_secret' => $oauth_token_secret,
			);
			
			return $new_douban_oauth->getAccessToken( $oauth_token_secret );

		}
		
		
		
		/**
			(session)
		 *	获得当前豆瓣登录用户信息
		 */
		function get_self( ) {

			//return $douban_oauth->oAuthRequest( 'http://api.douban.com/people/' . $douban_access_token['douban_user_id'], array(
			//	'alt' => 'json',
			//), 'GET');
			$ci =& get_instance();
			$douban_access_token = $ci->session->userdata('douban_access_token');
			
			return $this->_request_access_douban_session('http://api.douban.com/people/' . $douban_access_token['douban_user_id']);
		}
		
		
		/**
		 *	从 CodeIgniter的session获取豆瓣access token~
		 		进而取得客户端
		 			直接进行 request
		 */
		private function _request_access_douban_session( $url, $params=array() , $method='GET' ) {
			$ci =& get_instance();
			$douban_access_token = $ci->session->userdata('douban_access_token');
			
			$douban_oauth = new DoubanOAuth( DOUBAN_KEY, DOUBAN_SECRET, $douban_access_token['oauth_token'], $douban_access_token['oauth_token_secret'] );
				
			$params += array(
				'alt' => 'json', // 默认始终输出json
			);
				
			// json 返回数组
			return json_decode( $douban_oauth->oAuthRequest( $url, $params, $method ) ,true);
		}
		
		
	}
