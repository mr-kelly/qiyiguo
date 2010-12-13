<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('t_sina_weibo_oauth/weibooauth.php');



/**
 *		自行编辑的 新浪微博library
 */
class t_sina {
	

	
	function __construct() {
		//$this->callback_url = site_url();
		
		
		
		$this->ci =& get_instance();
		
		$this->app_key = $this->ci->config->item('t_sina_oauth_key');
		$this->app_secret = $this->ci->config->item('t_sina_oauth_secret');

		
		
		//$this->oauth = new WeiboOAuth( $app_key, $app_secret );
		
		
	}
	
	
	function is_authorized() {
		// 检查session
		$t_sina_keys = $this->ci->session->userdata('t_sina_keys');
		if ( $t_sina_keys == false ) {
			return false;
		}
		
		// 检查输出
		
		
		
		
		return true;
	}
	/**
	 *	需指定callback_url,  完成authorize后，转到callback_url
	 */
	function get_authorize_url( $callback_url='' ) {
		
		if ( $callback_url == '' ) {
			$callback_url = $this->ci->config->item('t_sina_callback_url');
		}
		$oauth = new WeiboOAuth( $this->app_key, $this->app_secret );
		
		$oauth_keys = $oauth->getRequestToken();
		
		$aurl = $oauth->getAuthorizeURL(  $oauth_keys['oauth_token'] ,false ,  $callback_url ); //$_SERVER['SCRIPT_URI'].
		
		// 储存session
		$this->ci->session->set_userdata( 't_sina_keys', $oauth_keys );
		
		return $aurl;
	}
	
	/**
	 *	通过session数据处理， 获得access_token, 放到session   last_key, 
	 
	 	用于action
	 */
	function get_access_token( $oauth_verifier =  '') {
		$oauth_keys = $this->ci->session->userdata('t_sina_keys');
		$oauth_token = $oauth_keys['oauth_token'];
		$oauth_token_secret = $oauth_keys['oauth_token_secret'];
		
		$oauth = new WeiboOAuth( $this->app_key, $this->app_secret, $oauth_token, $oauth_token_secret );
		
		
												// 认证码
		$last_key = $oauth->getAccessToken( $_GET['oauth_verifier'] );
		
		$this->ci->session->set_userdata( 't_sina_keys', $last_key );
		
		
	}
	
	function get_weibo_client() {
		$t_sina_key = $this->ci->session->userdata('t_sina_keys');
		
		// 如果未设置key, 连接到认证页
		if ( $t_sina_key == false ) {
			redirect( $this->get_authorize_url() );
		}
		
		//var_dump( $t_sina_key );
		$weibo = new WeiboClient( $this->app_key, $this->app_secret, $t_sina_key['oauth_token'], $t_sina_key['oauth_token_secret'] );
		
		return $weibo;
	}
}