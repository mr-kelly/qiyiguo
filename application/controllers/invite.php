<?php
	/**
	 *	邀请朋友加入 （MSN邮箱、微博）
	 */
	class Invite extends KK_Controller {
	
		function index() {
			login_redirect();
			
			$render = array();
			kk_show_view('invite/index_view', $render);
		
		}
		
		/**
		 *	发送新浪微博...
		 */
		function t_sina() {
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				$this->form_validation->set_rules('t_sina','微博内容', 'required|trim|xss_clean');
				
				if ( !$this->form_validation->run() ) {
					$this->session_message->set('微博内容不能为空');
					redirect('invite');
				} else {
					// 发微博开始
					$this->load->library('T_sina');
					$weibo = $this->t_sina->getUserWeibo( get_current_user_id() );
					
					if ( $weibo_update = $weibo->update( $this->form_validation->set_value('t_sina') ) ) {
					
						$this->session_message->set('你的微博已发送！');

					} else {
						$this->session_message->set('微博发送失败');
					}
					
					redirect('invite');
					
				}
			}
			
			echo 'error! direct here!';
		}
	}