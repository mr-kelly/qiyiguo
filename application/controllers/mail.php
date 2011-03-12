<?php

	class Mail extends KK_Controller {
		
		
		/**
		 *	发送邮件
		 */
		function index() {
			login_redirect();
			
			$this->load->model('user_profiles_model');
			$this->load->library('KK_Mailer');
			
			// 若为post提交,处理, 发送邮件email~
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				
				$this->form_validation->set_rules('mail_send_to', '收信人', 'trim|required|xss_clean|callback__numeric_array_check'); // 数字数组字符串
				$this->form_validation->set_rules('mail_topic', '信件主题', 'trim|required|xss_clean');
				$this->form_validation->set_rules('mail_content', '信件内容', 'trim|required|xss_clean');
				
				if ( ! $this->form_validation->run() ) {
					// 表单验证不通过~
					ajaxReturn( null, validation_errors(), 0);
				} else {
					echo 'send it!';
					
					// mail_send_to,   收信人的ID数组
					$mail_send_to = explode( ',' , $this->form_validation->set_value('mail_send_to') );
					$mail_topic = $this->form_validation->set_value('mail_topic');
					$mail_content = $this->form_validation->set_value('mail_content');
					
					// 获取ID对应的用户详细信息
					foreach( $mail_send_to as $key=>$user_id ) {
					
						// $mail_send_to 变化, 变成 收信人 用户信息profile
						$mail_send_to[$key] = $this->user_profiles_model->_get_user( $user_id );
					
					}
					
					
					/**
					 *	分别对每个用户发送邮件~  对方可一次回复所有用户,类似Mailist
					 
					 	对每个用户发信, 规则如下:
					 		收信人可直接按回复(reply_to), 回复关于这封邮件的所有人(除了自己)~
					 		
					 */
					
					// 收信人Emails数组, 发给XXXX
					$mail_to_user_list = array();
					foreach ( $mail_send_to as $user ) {
						array_push( $mail_to_user_list , array( $user['email'] , $user['name'] ) );
					}
					
					// 寄信人,回复人Emails数组, // 回复人, 加上自己, 让对方可以回复自己
					$mail_from_user_list = $mail_to_user_list;
					array_push( $mail_from_user_list, array(
							get_current_user_profile('email'),
							get_current_user_profile('name'),
						));
					// 发Mails
					$this->kk_mailer->send_mail( array(
						'to' => $mail_to_user_list,
						'from' => get_current_user_profile('email'),
						'from_name' => get_current_user_profile('name'),
						'reply_to' => $mail_from_user_list,
						
						'subject' => $mail_topic, 
						'body' => $mail_content,
					));
					
						
					// mail_send_to 数组 每个值必须是数字
					ajaxReturn( null, "Success Mailed!", 1 );
				}
				
			}
			
			
			
			// 正常GET状态 ==> GET
			
			// 验证GET['send_to']合法性, 否,显示错误
			if ( ! $this->_numeric_array_check( $this->input->get('send_to') ) ) {
				log_message('error', 'GET["send_to"]不合法!');
				show_error('GET["send_to"]不合法!');
			}
			
			// 获取GET的sent_to数组ID => 将向以下ID的用户发送信件
			$send_to = explode( ',', $this->input->get('send_to') );
			
			
			// 将 user array ID转变成相对的用户资料
			foreach ( $send_to as $key=>$user_id ) {
				$send_to[$key] = $this->user_profiles_model->_get_user( $user_id );
			}
			
			$data = array(
				'send_to' => $send_to,
			);
			$this->load->view('mail/index_view.php', $data);
		}
		
		
		
		
		
		/** 
		 *	验证 1,2,3,4 这样的字符数组 , 转成数组, 每个项都要是数字
		 			失败例子   1,2,       1,2,adsf,3
		 			
		 				防止黑客攻击,注入
		 */
		function _numeric_array_check( $str ) {
			$this->form_validation->set_message('_numeric_array_check', '收信人ID非数字!');
			$array = explode( ',', $str );
			
			
			foreach ( $array as $num ) {
				// 若遇到不是数字的, 返回失败~
				if ( ! is_numeric( $num ) ) {
					return false;
				}
			}
			
			// 成功验证~
			return true;
		}
	}