<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	// Session 消息，用于处理页面刷新、重定向后提示用户的信息
	class Session_Message {
		function __construct() {
			$this->ci =& get_instance();
		}
		
		// set 完后，应该redirect会指定页面！
		function set( $message ) {
			$this->ci->session->set_userdata('session_message', $message);
		}
		
		function get() {
			$session_message = $this->ci->session->userdata('session_message');
			
			// 清除
			$this->ci->session->set_userdata('session_message', null );
			
			return $session_message;
		}
	}