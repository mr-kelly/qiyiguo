<?php

// 过期，不用了！
class Oauth extends KK_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('t_sina');
	}
	function index() {
	
	}
	
	function test() {
		var_dump($_SESSION);
	}
	
	// 获得token, 转接
	function t_sina_callback() {
		
		// 如果没设置oauth_token
		$this->t_sina->get_access_token();
		
		//echo 'authorized!';
		redirect('/oauth/t_sina_home_timeline/');

		
	}
	
	function t_sina_home_timeline() {
		$weibo = $this->t_sina->get_weibo_client();
		
		var_dump( $weibo->home_timeline() );
	}
}