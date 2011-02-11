<?php
	class Group extends KK_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model('group_model');
			$this->load->model('request_model');
			$this->load->model('chat_model');
		}
		
		function index() {
			$data = array(
				'groups' => $this->group_model->get_groups(null),
				'current_group' => 'current_menu',
			);
			kk_show_view('group/index_view', $data);
		}
		
		
		function test() {
			$message =  $this->input->post('message');
			
			echo $message == null ? 'null' : 'ok';
		}
		
		
		
		/**
		 *	友群的设置， 需要管理员权限
		 */
		function setting($group_id, $action = 'setting' ) {
			login_redirect();
			$this->_if_group_404( $group_id );
			
			if ( $action == 'setting' ) {
				$data = array(
					'group' => $this->group_model->get_group_by_id( $group_id ),
				);
				
				kk_show_view('group/setting_view', $data);
				
			} else if ( $action == 'members' ) {
				
				$render = array();
				$render['group_members'] = $this->group_model->get_group_users( $group_id );
				
				kk_show_view('group/setting_members_view', $render);
			
			
			}
		}
		
		/**
		 *	上传群组logo标志
		 */	
		function logo_upload($group_id) {
			login_redirect();
			$data = array();
			
			$group_path = $this->config->item('group_logo_path') . $group_id;
			
			$this->_createDir($group_path);
			
		    $config['upload_path'] = $group_path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '2048';   //可以上传2MB
			$config['max_width']  = '2024';
			$config['max_height']  = '1768';
			$config['overwrite'] = true;  //覆盖
			$config['file_name'] = 'group_logo_' . $group_id . '.png' ;
			
			$this->load->library('upload', $config);
			
			if ( !$this->upload->do_upload() ) {
				// 上传失败信息
				//$this->session_message->set( $this->upload->display_errors() );
				
				$data['group_id'] = $group_id;
				$data['page_message'] = $this->upload->display_errors();
				
				
				
			} else {
				//上传成功，
				// 提供裁剪界面...
				$upload_data = $this->upload->data();
				$data['group_id'] = $group_id;
				$data['upload_data'] = $upload_data;
				$data['logo_url'] = static_url() . 'upload/groups/' . $group_id .'/' . $upload_data['file_name'];

			}
			
			
			$this->load->view('group/logo_upload_view', $data );
		}
		
		/**
		 *	将 Group Logo裁剪成正方形
		 */
		function logo_crop($group_id) {
			login_redirect();
			
			$x1 = $this->input->post('x1');
			$y1 = $this->input->post('y1');
			$x2 = $this->input->post('x2');
			$y2 = $this->input->post('y2');
			$logo_file = $this->input->post('logo_file');
			$logo_path = $this->config->item('group_logo_path') . $group_id;
			
			$width = $x2 - $x1;  // 根据x2, y2确定新图片高度
			$height = $y2 - $y1;
			
			$img_config = array(
				'image_library' => 'gd2',
				'source_image' => $logo_path . '/group_logo_' . $group_id . '.png',
				'maintain_ratio' => false,  //要裁剪成正方形～不保持原来比例
				'width' => $width,
				'height' => $height,   
				
				'x_axis'=> $x1,
				'y_axis'=>$y1,
				'create_thumb' => false,
			);
			
			$this->load->library('image_lib', $img_config);
			if ( !$this->image_lib->crop($x1, $y1)) {   // 裁剪！
				echo $this->image_lib->display_errors();
			} else {
				
				$this->group_model->set_group_logo($group_id);

				echo 'success!';
			}
		}
		
		
		/**
		 *   Group 查看单项
		 */
		function group_lookup($group_id, $action='index', $do='') {
			
			$this->_if_group_404( $group_id );
			
			$this->load->model('chat_model');
			
			if ( !$this->tank_auth->is_logged_in() ) {
				redirect('user/login?redirect=/group/'. $group_id);
			}
			
			
			/** 友群权限 */
			$current_user_id = $this->tank_auth->get_user_id();
			
			// 判断是否private私有群组，并且用户不属于该群组，那么，转到禁止进入页面 )
			if ( $this->group_model->is_group_private($group_id) && !$this->group_model->is_group_user( $group_id, $current_user_id ) ) {
				redirect('group/forbidden/'. $group_id );
			}
			
			
			/**
			 *	****** 开始，群组首页
			 */
			 
			 

			$group = $this->group_model->get_group_by_id($group_id);
			
			// 友群话题，并在里面包含latest chat
			$this->load->model('topic_model');
			
			$topics = $this->topic_model->get_topics('group', $group_id);
			foreach ( $topics as $key=>$topic ) {
				$topics[$key]['latest_chat'] = $this->chat_model->get_latest_chat( 'topic', $topics[$key]['id'] );
			}
			
			
			$data = array(
				'group' => $group,
				'group_users' => $this->group_model->get_group_users($group_id),
				'topics' => $topics,
				
				'action' => $action,
				'current_group' => 'current_menu',
			);
			
			if ( $action == 'index' ) {
				// 群组首页
				kk_show_view('group/group_lookup_view', $data);
			} else if ( $action == 'topic' ) {
				// 群组话题页
				kk_show_view('group/group_lookup_topic_view', $data);
			} else if ( $action == 'stream' ) {
				// 群组信息盒子
				kk_show_view('group/group_lookup_stream_view', $data);
			} else if ( $action == 'members' ) {
				// 成员列表、成员管理
				kk_show_view('group/group_lookup_members_view', $data);
			} else if ( $action == 'chat' ) {
				// 聊天
				kk_show_view('group/group_lookup_chat_view', $data);
			}
		}
		
		
		/**
		 *	无权限浏览群组 ( group_ lookup )
		 
		 		- 私有群组，不属于该成员
		 */
		function forbidden( $group_id ) {
			$data = array();
			$this->load->view('group/forbidden_view', $data);
		}
		
		
		
		///////////    Ajax 下面
		
		
		function new_group() {
			// 若未登录，返回ajax失败
			login_redirect();
			
			// POST 提交，Ajax返回
			// group_name
			// group_privacy
			// group_category
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				//表单验证
				$this->form_validation->set_rules('group_name', '果群名称', 'trim|required|xss_clean');
				$this->form_validation->set_rules('group_privacy', '果群公开性', 'trim|required|xss_clean');
				$this->form_validation->set_rules('group_category', 'Group Category', 'trim|required|xss_clean');
				$this->form_validation->set_rules('group_verify', '加入友群验证方式', 'trim|required|xss_clean');
				
				if ( !$this->form_validation->run() ) {
					ajaxReturn( null, validation_errors(), 0);
				} else {
					// 验证成功，创建友群！
					$group_name = $this->form_validation->set_value('group_name');
					$group_privacy = $this->form_validation->set_value('group_privacy');
					$group_category = $this->form_validation->set_value('group_category');
					$group_verify = $this->form_validation->set_value('group_verify');
					
					$owner_id = $this->tank_auth->get_user_id();  // 创始人 user id
					
					$group_id = $this->group_model->create_group($group_name, $group_category, $group_privacy,$group_verify, $owner_id=$owner_id);
					
					ajaxReturn(
						array(
							'group_name' => $group_name,
							'group_id' => $group_id, 
						),
						'成功创建友群！', 1);
				}
				
				ajaxReturn( null, $this->input->post('group_category'), 0);
			}
			
			
			$data = array(
				'group_categories' => $this->group_model->get_group_categories(),
				'current_group' => 'current_menu',
			);
			kk_show_view('group/new_group_view', $data);
		}
		
		
		
		///////////////////// iframe 下面
		/**,. 
		 *   让当前登录用户加入友群 iframe
		 *   $action   ->   join 加入       exit  退出友群
		 */
		function ajax_join_group($group_id) {
			if ( !$this->tank_auth->is_logged_in() ) {
				exit('Error!! You directly enter here?');
			}
			$user_id = $this->tank_auth->get_user_id();
			$group = $this->group_model->get_group_by_id($group_id);
			
			// 判断group是否需要request verify
			if ( $group['verify'] == 'everyone' ) {
 				// 每个人都可以加入，无需验证
 				// 执行 友群加入用户~  
				$result = $this->group_model->create_group_user($group_id, $user_id);
				if ( $result ) {
					ajaxReturn( null, '成功加入'.$group['name'], 1);
				} else {
					ajaxReturn(null, '加入失败，可能已加入', 0);
				}
				
			} elseif ( $group['verify'] == 'request' ) {
				// 无message, 返回0，  data为 message, 示意弹出提示框输入message!
				$message = $this->input->post('message');
				if ( $message == '' ) {
					ajaxReturn( 'message', '请输入message', 0);
				}
				
				// 若已经有$message需要验证请求，那么生成验证
				if ( $this->request_model->create_request_group($group_id, $user_id, $message) ) {
					ajaxReturn( null, 'success' ,1 );
				}
				
			}
			
			echo 'direct here?';
		}
		

		
		
		/**
		 *	获取友群所有成员的微博信息，合并.
		 */
		function ajax_get_group_t_sina( $group_id ) {
			
			// 获得t_sina_stream
			$t_sina_array = $this->group_model->get_group_users_t_sina( $group_id );
			$stream = $this->stream->get_t_sina_stream( $t_sina_array );
			
			$data = array(
				'stream' => $stream,
			);
			
			$this->load->view('stream/ajax_get_stream_view', $data );
			

			
		}
		
		
		/**
		 *	Ajax 添加 友群活动
		 */
		function ajax_create_event() {
		
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				
				$this->form_validation->set_rules('event_group_id', 'Event Group ID', 'trim|required|xss_clean|integer');
				
				$this->form_validation->set_rules('create_event_start_date','Event Start Date', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_start_hour', 'Event Start Hour', 'trim|required|xss_clean|integer');
				$this->form_validation->set_rules('create_event_start_min', 'Event Start Min', 'trim|required|xss_clean|integer');
				$this->form_validation->set_rules('create_event_end_date', 'Event End Date', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_end_hour', 'Event End Hour', 'trim|required|xss_clean|integer');
				$this->form_validation->set_rules('create_event_end_min', 'Event End Min', 'trim|required|xss_clean|integer');
				
				$this->form_validation->set_rules('create_event_name', 'Event Name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('create_event_content', 'Event Content', 'trim|required|xss_clean');
				
				
				if ( ! $this->form_validation->run() ) {
					// 不通过表单验证~
					AjaxReturn ( null, validation_errors() , 0 );
				} else {
				
					$event_group_id = $this->form_validation->set_value('event_group_id');
					$create_event_start_date = $this->form_validation->set_value('create_event_start_date');
					$create_event_start_hour = $this->form_validation->set_value('create_event_start_hour');
					$create_event_start_min = $this->form_validation->set_value('create_event_start_min');
					$create_event_end_date = $this->form_validation->set_value('create_event_end_date');
					$create_event_end_hour = $this->form_validation->set_value('create_event_end_hour');
					$create_event_end_min = $this->form_validation->set_value('create_event_end_min');
					
					$create_event_name = $this->form_validation->set_value('create_event_name');
					$create_event_content = $this->form_validation->set_value('create_event_content');
					
					$this->load->model('event_model');
					$this->event_model->create_event( array(
						
						'start' => $create_event_start_date . ' '. $create_event_start_hour . ':' . $create_event_start_min . ':00',
						'end' => $create_event_end_date . ' '. $create_event_end_hour . ':' . $create_event_end_min . ':00',
						'name' => $create_event_name,
						'content' => $create_event_content,
						'model' => 'group',
						'model_id' => $event_group_id,
						'user_id' => $this->tank_auth->get_user_id(),
						
					));
					
					echo 'ok';
				}
			}
		// 	if ($_SERVER['REQUEST_METHOD'] == "POST") {
// 				$this->form_validation->set_rules('topic_title','Topic Title', 'trim|required|xss_clean');
// 				$this->form_validation->set_rules('topic_content','Topic Content', 'trim|required|xss_clean');
// 				$this->form_validation->set_rules('topic_group_id','Topic Group', 'trim|required|xss_clean');
// 				
// 				if ( !$this->form_validation->run() ) {
// 					ajaxReturn( null, validation_errors(), 0);
// 				} else {
// 					// 表单验证成功
// 					$user_id = $this->tank_auth->get_user_id();
// 					$topic_title = $this->form_validation->set_value('topic_title');
// 					$topic_content = $this->form_validation->set_value('topic_content');
// 					$topic_group_id = $this->form_validation->set_value('topic_group_id');
// 					
// 					$this->group_model->create_group_topic($topic_group_id, $user_id, $topic_title, $topic_content);
// 					ajaxReturn( null, '成功发布主题!', 1);
// 				}
// 				
// 				
// 			}
// 			
		}
		
		/**
		 *	ajax 对应group的topics ( parent_id=0 )
		 */
// 		function group_chats($group_id) {
// 			$chats = $this->chat_model->get_chats('group',$group_id);
// 
// 			$data = array(
// 				'chats' => $chats,
// 				'group_id' => $group_id,
// 			);
// 			$this->load->view('group/group_chats_view', $data);
// 		}
// 
// 		function comments( $chat_id ) {
// 			
// 		}
		
		
		
		
		
		
		/**
		 *	创建目录函数，用于上传头像是自动生成用户的头像图片存放文件夹
		 */
		function _createDir($path) {
		   if (!file_exists($path)) {
		   	
			$this->_createDir(dirname($path));
		
			mkdir($path, 0777);
		   }
		}
		
		
		/**
		 *	用于判断当前action所需要的group对象是否存在，不存在，404页面吧
		 */
		function _if_group_404( $group_id ) {
			if ( !$this->group_model->get_group_by_id( $group_id ) ) {
				show_404();
			}
		}
		
	}