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
			
			// 寻找request, 如果有加入群组的请求...显示为Notice
			$this->load->model('request_model');
			$request_num = $this->request_model->get_request_admin_groups_num( get_current_user_id() );
			if ( $request_num ) {
				$user_notices[] = array(
					'id' => 0,
					'title' => '加入请求',
					'content' => sprintf( '你有%d个加入群组请求...<a href="%s">&gt;去处理</a>', $request_num, site_url('request') ),
					'link' => '',
					'model' => 'request',
					'model_id' => 0,
					'user_id' => get_current_user_id(),
					
					//'user_profile' => get_current_user_profile(),
				);
			}
			
			
			
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
			
			// 未登录或poke的不是自己的notice 或不存在～ 不存在，返回..
			if ( !is_logged_in() || 
					! $notice ||
					$notice['user_id'] != get_current_user_id() ) {
					
					
				$this->session_message->set( '提醒已处理过了...' );
				
				if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
					redirect( $_SERVER['HTTP_REFERER'] );
				} else {
					redirect( '/' );
				}
				//ajaxReturn( null, '你动了别人的奶酪(提醒)', 0 );
				
				return;
			}
			
			// 处理notice
			$link = $notice['link'];
			
			// 本条notice已经poke(处理), 删除，转到指定页面
			$this->notice_model->poke_notice_by_id( $notice_id );
			
			redirect( $link );
			
			
		}
		
	}