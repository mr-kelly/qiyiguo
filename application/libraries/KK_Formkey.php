<?php

	/**
	 *	表单加密技术，用于取代验证码功能。
	 
		 注意： 专利技术。 别盗用
	 */
	class KK_Formkey {
		
		/** 
		 *	生成数组包括form key & token 。 并且，放入session
		 */
		function create_key_token() {
			$ci =& get_instance();
			
			$form_key = md5( rand() );
			$form_token = md5( rand() );
			
			$ci->session->set_userdata('form_key', $form_key );
			$ci->session->set_userdata('form_token', $form_token);
			
			return array(
				'form_key' => $form_key,
				'form_token' => $form_token,
			);
		}
		
		
		
		/**
		 *	检查session中的key,token 字符串相加是否想同
		 */
		function check_key_token( $key_token ) {
			$ci =& get_instance();
			
			return ( $key_token == $ci->session->userdata('form_key') . $ci->session->userdata('form_token')  );
		}
	
	}