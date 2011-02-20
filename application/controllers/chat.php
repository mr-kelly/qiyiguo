<?php
	class Chat extends KK_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model('chat_model');
		}
		
		
		function test() {

			
			// $data = array();
// 
// 			$chats = $this->chat_model->get_chat(2);

			//$this->chat_model->children = array();
			//$chats = $this->chat_model->get_chat_and_children(1);
			
			// 新浪微博链接
			
// 			$this->load->library('t_sina');
// 			
// 			$callback_url = $this->config->item('t_sina_callback_url');
// 			echo '<a href="' . $this->t_sina->get_authorize_url( $callback_url ) . '">OAuth It</a>';
// 			
// 			$s = $this->session->userdata('abc');
// 			var_dump ( $s);
			
			$data =array();
			$this->load->view('test', $data);
		}

		
		/**
		 *	添加新聊天,  ajax
		 *  $for - 指定对应的模型   group / user
		 *   is_title 是否需要标题title
		 */
		function add($model, $model_id=0) {
			login_redirect();
			
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				// if ( $is_title ) {
// 					// 需要title, is_title 不等于false
// 					$this->form_validation->set_rules('chat_title','Chat Title', 'trim|required|xss_clean');
// 				} else {
// 					// 不需要 title
// 					$this->form_validation->set_rules('chat_title','Chat Title', 'trim|xss_clean');
// 				}
				
				$this->form_validation->set_rules('chat_content','评论内容', 'trim|required|xss_clean');
				$this->form_validation->set_rules('chat_parent_id', 'Chat Parent', 'trim|required|xss_clean|numeric');

				
				if ( !$this->form_validation->run() ) {
					ajaxReturn( null, validation_errors(), 0 );
				} else {
					$title = $this->form_validation->set_value('chat_title');
					$content = $this->form_validation->set_value('chat_content');
					$user_id = $this->tank_auth->get_user_id();
					$parent_id = $this->form_validation->set_value('chat_parent_id');
					
					
					$this->chat_model->create_chat($model, $model_id, $title, $content, $parent_id, $user_id);
					
					
					// chat添加后，重定向,用于iframe Chat
					//if ( isset( $_GET['redirect'] ) ){
					//	redirect( $this->input->get('redirect') );
					//}
					
					ajaxReturn( 
						array( 
							'get_chats_url'=> site_url('chat/ajax_get_chats/' . $model.'/'.$model_id ) 
						), 
						'succes create', 1
					);
				}
				
				
			}
			
			ajaxReturn( null,  'add chat' , 0 );
		}
		
		
		function ajax_get_chats( $model, $model_id ) {
		
			$data = array();
			$data['chats'] = $this->chat_model->get_chats($model, $model_id, null);
			
			$data['model'] = $model;
			$data['model_id'] = $model_id;
			
			$this->load->view('chat/ajax_get_chats_view', $data);
		}
		
		
// 		function add_topic( $model, $model_id) {
// 			$this->_add($model, $model_id,  true);
// 		}
// 		
// 		function add_comment( $model, $model_id ) {
// 			// 通过post传入parent_id
// 			$this->_add( $model, $model_id, false);
// 		}
		
		
	}