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
		 *	获得指定的chat
		 */
		function get_chat_by_id( $chat_id ) {
			$chat = $this->db->get_where('chat', array(
				'id' => $chat_id,
			));
			
			if ( $chat->num_rows() == 0 ) {
				return false;
			}
			
			$chat = $chat->row_array();
			
			return $chat;
		}
		

		
		
		/**
		 *	添加新聊天,  ajax
		 *  $for - 指定对应的模型   group / user
		 *   is_title 是否需要标题title
		 */
		function add($model, $model_id=0) {
			
			// 未登录，提示登录~
			if ( !is_logged_in() ) {
				ajaxReturn( 'login_redirect', '未登录,你不能回复 <a href="#" onclick="$(\'#login_btn\').trigger(\'click\');return false;">登录</a>', 0);
			}
			
			
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				// if ( $is_title ) {
// 					// 需要title, is_title 不等于false
// 					$this->form_validation->set_rules('chat_title','Chat Title', 'trim|required|xss_clean');
// 				} else {
// 					// 不需要 title
// 					$this->form_validation->set_rules('chat_title','Chat Title', 'trim|xss_clean');
// 				}
				
				$this->form_validation->set_rules('chat_content','评论内容', 'trim|required|xss_clean|htmlspecialchars|max_length[200]');
				$this->form_validation->set_rules('chat_parent_id', 'Chat Parent', 'trim|required|xss_clean|numeric');

				
				if ( !$this->form_validation->run() ) {
					ajaxReturn( null, validation_errors(), 0 );
				} else {
					$title = $this->form_validation->set_value('chat_title');
					
					$content = $this->kk_filter->filter( 
									$this->form_validation->set_value('chat_content')
								);
								
					$user_id = get_current_user_id();
					$parent_id = $this->form_validation->set_value('chat_parent_id');
					
					
					$this->chat_model->create_chat($model, $model_id, $title, $content, $parent_id, $user_id);
					
					/**
					 *	User Notice
					 */
					// 添加chat后，提醒parent用户~  先获取chat, 再获取chat的user_id.
					$current_user_name = get_current_user_name();
					
					if ( $parent_chat = $this->chat_model->get_chat_by_id( $parent_id ) ) {
						// Chat 回复 Chat 的提醒
						// 如果parent_id为0， 那么向 model_id 的user提醒~  // 当前用户不提醒
						if ( get_current_user_id() != $parent_chat['user_id'] ) {
						
							add_notice( $parent_chat['user_id'], 
											'新的聊天回复', 
											sprintf('%s回复了你', $current_user_name ), // 当前用户~提醒对方
											sprintf('/%s/%s/%s', $model, $model_id,   $model == 'user' ? 'chat' : ''),
											$model,
											$model_id
											);
						}
						
					} else {
						// parent_id为0， 向 model 回复, 先获取model所属user_id
						
						// 提醒:  发送提醒给对方用户，   当前用户回复了你
						if ( $model == 'topic' ) {
							$this->load->model('topic_model');
							$model_object = $this->topic_model->get_topic_by_id( $model_id );
							$model_user_id = $model_object['user_id'];
							
							if ( $model_object['title'] != '' ) {
								// 有标题传送标题
								$notice_content = $model_object['title']; // 回复的主题的内容
							} else {
								$notice_content = kk_content_preview( $model_object['content'], 40 );
								//$notice_content = substr( $model_object['content'], 0 , 40 );
							}
							
							
							if ( get_current_user_id() != $model_user_id ) {
							
								add_notice( $model_user_id,
											'新的留言',
											sprintf('%s向你留言了...「%s」', $current_user_name, $notice_content),
											//$current_user_name . '向「' . $notice_content .'」留言了'  ,
											sprintf('/%s/%s', $model, $model_id ),
											$model,
											$model_id,
											'chat'
											);
											
							}
										
						} elseif ( $model == 'user') {
							if ( get_current_user_id() != $model_id ) {
							
								add_notice( $model_id, // User_ID 提醒对方
												'新的个人聊天', 
												sprintf('%s向你留言了', $current_user_name ),
												sprintf('/%s/%s/chat', $model, $model_id),
												$model,
												$model_id,
												'chat'
												);
												
							}
						} elseif ( $model == 'event' ) {
							$this->load->model('event_model');
							$model_object = $this->event_model->get_event_by_id( $model_id );
							$model_user_id = $model_object['user_id'];
							
							if ( get_current_user_id() != $model_user_id ) {
								add_notice( $model_user_id, // User_ID 提醒对方
												'新的活动聊天', 
												sprintf('%s在你的活动留言了', $current_user_name ),
												sprintf('/%s/%s', $model, $model_id),
												$model,
												$model_id,
												'chat'
												);
							}
											
						}

					}
					
					
					// chat添加后，重定向,用于iframe Chat
					//if ( isset( $_GET['redirect'] ) ){
					//	redirect( $this->input->get('redirect') );
					//}
					
					ajaxReturn( 
						array( 
							'get_chats_url'=> site_url('chat/ajax_get_chats/' . $model.'/'.$model_id .   sprintf( '?ajax=%s&chat_width=%s', rand(), $this->input->get('chat_width'))  ) // 特別處理，令刷新讀取後，依然是想要的width
						), 
						'succes create', 1
					);
				}
				
				
			}
			
			ajaxReturn( null,  'fail add chat' , 0 );
		}
		
		
		function ajax_get_chats( $model, $model_id ) {
		
			$data = array();
			$data['chats'] = $this->chat_model->get_chats($model, $model_id, null);
			
			$data['model'] = $model;
			$data['model_id'] = $model_id;
			
			$this->load->view('chat/ajax_get_chats_view', $data);
		}
		
		
		
		/**
		 *	删除评论
		 */
		function ajax_delete_chat( $chat_id ) {
			
			if ( !is_logged_in() ) {
				ajaxReturn( 'login_required', '未登录', 0 );
			}
			
			// 判断评论是否属于当前用户的...
			$chat = $this->chat_model->get_chat_by_id( $chat_id );
			
			if ( $chat['user_id'] == get_current_user_id() ) {
				if ( $this->chat_model->del_chat( $chat_id ) ) {
					ajaxReturn( null, '成功删除评论', 1);
				} else {
					ajaxReturn( null, '无法删除评论', 0);
				}
				
			}
			
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