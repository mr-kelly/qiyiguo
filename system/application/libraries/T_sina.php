<?php

	require_once('t_sina_http_auth/weibo.class.php');
	
	
	// 要先->weibo->setUser ( name, pw );
	
	/**
		Example:
		
			$this->load->library('T_sina');
			$this->t_sina->weibo->setUser('xxxx', 'xxxx');
			
			print_r( $this->t_sina->weibo->public_timeline());
	*/
	class T_sina {
	
	
		function __construct() {
			$ci =& get_instance();
			
			
			$app_key = $ci->config->item('t_sina_app_key');
			
			$this->weibo = new weibo( $app_key );
			
		}
		
		function checkUser($login, $password) {
			$this->weibo->setUser( $login, $password );
			
			$return = $this->weibo->verify_credentials();
			
			if ( isset($return['error']) ) {
				// 验证用户存在错误，返回错误
				return false;
			} else {
				 return true;
			}
			 
		}
		
		function getUser($login,$password) {
			$this->weibo->setUser( $login, $password );
			
			return $this->weibo->verify_credentials();
		}
		
		
		
		/**
		 *	传入用户id， 获取其user_t_sina表中的绑定数据, 发挥weibo客户端，供直接的使用
		 */
		function getWeibo( $user_id ) {
			// 获取用户的t_sina   login, password
			$ci =& get_instance();
			$ci->load->model('user_t_sina_model');
			$ci->load->library('fun_crypt');
			
			if ( $ci->user_t_sina_model->is_bind_user_t_sina( $user_id, 'by_id') ) {
				
				$user_t_sina = $ci->user_t_sina_model->get_user_t_sina( $user_id );
				
				// 解密加密的密码
				$this->weibo->setUser( $user_t_sina['t_sina_login'] , $ci->fun_crypt->deCrypt($user_t_sina['t_sina_password']) );
				
				return $this->weibo;
				
			} else {
				// 没绑定，返回错误，不能获得微博认证~
				return false;
			}
			
			
			
		}
		
		/**
		 * 将新浪微博信息的时间 ， 如 Fri Aug 27 22:24:45 +0800 2010
			 转换成timestamp
		 */
		function t_sina_timestamp($str_time) {
		
			$Month_E = array( 1  => "January",
							  2  => "February",
							  3  => "March",
							  4  => "April",
							  5  => "May",
							  6  => "June",
							  7  => "July",
							  8  => "August",
							  9  => "September",
							  10 => "October",
							  11 => "November",
							  12 => "December");
			$Month_S = array( 1  => "Jan",
							  2  => "Feb",
							  3  => "Mar",
							  4  => "Apr",
							  5  => "May",
							  6  => "Jun",
							  7  => "Jul",
							  8  => "Aug",
							  9  => "Sep",
							  10 => "Oct",
							  11 => "Nov",
							  12 => "Dec");
							  
							  
			$date = explode(' ', $str_time);
			$time = explode(':', $date[3]);
			
			$date['wday'] = $date[0];
			
			//$date['mon'] = intval($date[1]);
			
			// 由于mon 是英文缩写（Aug, Mon ), 令转换成数字月份
			foreach ( $Month_S as $key=>$mon ) {
				if ( $date[1] == $mon ) {
					$date['mon'] = $key;
				}
			}
			
			$date['mday'] = intval( $date[2] );
			$date['year'] = intval( $date[5] );
			$date['timezone'] = $date[4];
			
			$date['hour'] = intval( $time[0] );
			$date['minute'] = intval( $time[1] );
			$date['second'] = intval( $time[2] );
			
			return mktime( $date['hour'], $date['minute'], $date['second'], $date['mon'], $date['mday'], $date['year']);
			
			
		}
		
		
		
		
		
	}