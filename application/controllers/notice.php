<?php
	class Notice extends KK_Controller {
		
		function __construct() {
			parent::__construct();
			$this->load->model('notice_model');
		}
		/**
		 *	ajax方式获取用户的notice提醒
		 */
		function ajax_get_notices() {
			if ( ! is_logged_in() ) {
				ajaxReturn ( null, 'login_required', 0 );
			}
			
			$user_notices = $this->notice_model->get_notices( get_current_user_id() );
			
			if ( !empty( $user_notices )) {
				// 有提醒
				ajaxReturn( $user_notices, '用户的提醒', 1 );
			} else {
				// 没有提醒，返回null
				ajaxReturn( null, '用户没有提醒', 0);
			}
		}
		
		
		/**
		 *	触碰一个提醒，  并转到相应的网址....
		 */
		function poke( $notice_id ) {
			
			$notice = $this->notice_model->get_notice_by_id( $notice_id );
			
			// 未登录或poke的不是自己的notice 或不存在～
			if ( !is_logged_in() || 
					! $notice ||
					$notice['user_id'] != get_current_user_id() ) {
					
				ajaxReturn( null, '你动了别人的奶酪(提醒)', 0 );
				
				return;
			}
			
			// 处理notice
			$link = $notice['link'];
			
			// 本条notice已经poke(处理), 删除，转到指定页面
			$this->notice_model->del_notice( $notice_id );
			
			redirect( $link );
			
			
		}
		
	}