<?php

	class Topic extends KK_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model('topic_model');
			
		}
		
		
		
		function index() {
			$this->load->model('chat_model');
			
			$start = $this->input->get('start');
			
			$topics = $this->topic_model->get_random_topics();
			
			foreach ( $topics as $key=>$topic ) {
				$topics[$key]['latest_chat'] = $this->chat_model->get_latest_chat( 'topic', $topics[$key]['id'] );
			}
			
			$render['current_topic'] = true;
			$render['topics'] = $topics;
			$render['start'] = $start;
			$render['page_title'] = '果群话题';
			
			kk_show_view('topic/index_view', $render);
			
		}
		/**
		 *	编辑话题
		 */
		function edit( $topic_id ) {
			login_redirect();
			
			$topic = $this->topic_model->get_topic_by_id( $topic_id );
			
			// 话题发布者才可以修改
			if ( $topic['user_id'] != get_current_user_id() ) {
				exit( 'topic creater only' );
			}
			
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				$this->form_validation->set_rules('title', '标题', 'xss_clean|trim|htmlspecialchars');
				$this->form_validation->set_rules('content', '正文', 'xss_clean|required|trim');
				//$this->form_validation->set_rules('attach_img_id','附加图片', 'integer|xss_clean|trim');
				//$this->form_validation->set_rules('attach_file_id','附加文件', 'integer|xss_clean|trim');
				
				if ( !$this->form_validation->run() ) {
					ajaxReturn( null, validation_errors(), 0 );
				} else {
					// Create Topic
					$title = $this->kk_filter->filter( 
								$this->form_validation->set_value('title')
							);
					
					$content = $this->kk_filter->filter( $this->form_validation->set_value('content'),array(
						'without_html' => false,
					));
					//$attach_img_id = $this->form_validation->set_value('attach_img_id');
					//$attach_file_id = $this->form_validation->set_value('attach_file_id');
					
					// 过滤<meta>等非法标签
					//$content = strip_tags( $content, '<p><a><span><div><b><font>');
					
					
					$this->load->model('topic_model');
					$update_topic = $this->topic_model->update_topic( $topic_id, array(
																	'title' => $title,
																	'content' => $content,
																	));
											//$model, $model_id, 
											//			get_current_user_id(),  // Topic属于谁的
											//				$content, $title );
					
					//ajaxReturn( null, '成功创建话题~', 1);
					$this->session_message->set( '成功修改话题' );
					
					redirect( 'topic/' . $topic_id );
					
					// 读取修改后的话题
					$topic = $this->topic_model->get_topic_by_id( $topic_id );
					
				
				}
				
			}
			
			
			
			$render['topic'] = $topic;
			$render['topic_id'] = $topic_id;
			kk_show_view('topic/edit_view',$render);
		}
		function add_topic() {
			login_redirect();
			$this->load->model('group_model');
			
			
			$render['current_topic'] = true;
			$render['total_user_groups'] = $this->group_model->get_user_groups( get_current_user_id(), null );
			kk_show_view('topic/add_topic_view', $render);
		}
		
		/**
		 *	将一个topic转到另一个用户收藏的群组
		 */
		function transfer( $topic_id, $group_id=null ) {
			login_redirect();
			
			$topic = $this->topic_model->get_topic_by_id( $topic_id );
			
			// 先判断用户是否该话题群组的成员，是的话，提供转送视图
			if ( !is_group_user( $topic['model_id'] , get_current_user_id() ) ) {
				ajaxReturn(null, '你并不属于该群组，不能转送', 0);
			}
			
			if ( ! $group_id ) {

				// topic属于用户的群组。那么提供转发视图 ( 让用户从已加入的群里选择 )
				$render['user_groups'] = $this->group_model->get_user_groups( get_current_user_id(), null );
				$render['topic'] = $topic;
				
				kk_show_view( 'topic/transfer_view', $render);
				
				
			} else {
				// 设置了转送目标？～ 转送吧！
				// 判断转送的目标群组，用户是否已经加入
				if ( is_group_user( $group_id, get_current_user_id() ) ) {
					// 属于一员，可以转发
					if ( $copy_topic_id = $this->topic_model->copy_topic( $topic['id'] , $group_id, get_current_user_id() ) ) {
						$this->session_message->set( '成功转送话题' );
						
						// 转送后到转送的群组首页
						redirect( '/group/' . $group_id );
					} else {
						ajaxReturn( null, 'error copy topic', 0 );
					}
				}
			}
		}
		
		function ajax_delete( $topic_id ) {
		
			if ( !is_logged_in() ) {
				ajaxReturn('login_required', '未登录', 0 );
			}
			
			// 群组管理员，话题所属才可以删除
			$topic = $this->topic_model->get_topic_by_id( $topic_id );
			//$topic_group = kk_get_group( $topic['model_id'] );
			
			if ( $topic['user_id'] == get_current_user_id() ||
					is_group_admin( $topic['model_id'] , get_current_user_id() ) ) {
				
				if ( $this->topic_model->del_topic( $topic_id ) ) {
				
					ajaxReturn( null, '成功删除话题', 1 );
					
				} else {
				
					ajaxReturn( null, '无法删除话题', 0 );
					
				}
			} else {
				ajaxReturn( null, '没有权限（非群管理员或话题创建者）', 0);
			}
		}
		function ajax_add_topic( $model, $model_id ) {
		

		
			login_redirect();
			$this->load->library('KK_Filter');
			
			if ( $model == 'group' ) {
				$group = kk_get_group( $model_id );
			}
			
			// 群权限、 群成员（非统治模式），  群管理者（统治模式）才可以发话
			if ( 
				( is_group_user( $model_id, get_current_user_id() ) && !$group['admin_mode'] )
				||
				( is_group_admin( $model_id, get_current_user_id() ) && $group['admin_mode'] )
			   ) {
			   
			
				if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
					$this->form_validation->set_rules('title', '标题', 'xss_clean|trim|htmlspecialchars');
					$this->form_validation->set_rules('content', '正文', 'xss_clean|required|trim');
					$this->form_validation->set_rules('attach_img_id','附加图片', 'integer|xss_clean|trim');
					$this->form_validation->set_rules('attach_file_id','附加文件', 'integer|xss_clean|trim');
					
					if ( !$this->form_validation->run() ) {
						ajaxReturn( null, validation_errors(), 0 );
					} else {
						// Create Topic
						$title = $this->kk_filter->filter( 
									$this->form_validation->set_value('title')
								);
						
						$content = $this->kk_filter->filter( $this->form_validation->set_value('content'),array(
							'without_html' => false,
						));
						$attach_img_id = $this->form_validation->set_value('attach_img_id');
						$attach_file_id = $this->form_validation->set_value('attach_file_id');
						
						// 过滤<meta>等非法标签
						//$content = strip_tags( $content, '<p><a><span><div><b><font>');
						
						
						$this->load->model('topic_model');
						$topic_id = $this->topic_model->create_topic( $model, $model_id, 
															get_current_user_id(),  // Topic属于谁的
																$content, $title, 
																	$attach_img_id, $attach_file_id );
						
						ajaxReturn( $this->input->post('content'), '成功创建话题~', 1);
					
					}
					
				}
				
				// GET -->
				$render = array(
					'model' => $model,
					'model_id' => $model_id,
				);
				
				kk_show_view('topic/ajax_add_topic_view', $render);
				
			} else {
				ajaxReturn( null, '群组权限不足,无法发话', 0 );
			} // END 权限判断
		}

	
	
	
	
		/**
		 *	小组主题
		 */
		function topic_lookup($topic_id = 0) {
			
			
			up_topic_page_view( $topic_id );
			
			$this->load->model('topic_model');
			
// 			if ($_SERVER['REQUEST_METHOD'] == "POST") {
// 				$this->form_validation->set_rules('topic_title','Topic Title', 'trim|xss_clean');
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
			clean_notices( get_current_user_id(), 'topic', $topic_id );
			

			
			
			$topic = $this->topic_model->get_topic_by_id($topic_id);
			if ( !$topic ) {
				show_404();
			}
			
			// 判断话题所属群组是否是私有群组， 
			$topic_group = kk_get_group( $topic['model_id'] );
			if ( $topic_group['privacy'] == 'private' ) {
				// 如果是，判断是否为群组成员，成员才可以查看
				if ( !is_group_user( $topic_group['id'], get_current_user_id() )) {
					$render['group'] = $topic_group;
					$render['topic'] = $topic;
					kk_show_view( 'topic/topic_forbidden_view', $render );
					return;
				}
			}
			
			$data['current_topic'] = true;
			$data['page_title'] = !empty( $topic['title'] ) ? $topic['title'] : kk_content_preview( $topic['content'], 102 );
			$data['topic'] = $topic;
			
			$this->load->view('topic/topic_view', $data);
			
			
		}
		
		/**
		 *	我的群话题...
		 */
		function my_topics() {
			login_redirect();
			
			$this->load->model( 'stream_model' );
			$this->load->model('chat_model');
			
			$start = $this->input->get( 'start' );
			$per_page = 20; // 每页显示...
			
			
			$user_groups_topics = $this->stream_model->get_user_groups_topics( get_current_user_id(), $per_page, $start );
			
			foreach ( $user_groups_topics as $key=>$topic ) {
				$user_groups_topics[$key]['latest_chat'] = $this->chat_model->get_latest_chat( 'topic', $user_groups_topics[$key]['id'] );
			}
			$render['current_topic'] = true;
			$render['start'] = $start;
			$render['per_page'] = $per_page;
			$render['my_topics_count'] = $this->stream_model->get_user_groups_topics_count( get_current_user_id() );
			
			// 获取用户关注群组的topics
			$render['user_groups_topics'] = $user_groups_topics;
			$render['user_topics'] = $this->topic_model->get_user_topics( get_current_user_id(), 5);
			
			
			kk_show_view('topic/my_topics_view', $render);
		}
		
		
		
		/**
		 *	话题的附加图片
		 */
		function ajax_topic_upload_pic() {
			
			//ajaxReturn( 'abc', '这里还行', 0);
			
			$upload_path = sprintf("%sattach_img/%s", $this->config->item('upload_path'), date('Y/m/d/') ) ; // 根据年月日上传目录
			$this->_createDir($upload_path);
			
			$upload_config = array(
				'upload_path' => $upload_path,
				'allowed_types' => 'gif|jpg|png',
				'max_size' => '2048',
				'max_width' => '4096',
				'max_height' => '3000',
				'encrypt_name' => true, // 随机名
			);
			
			$this->load->library('upload', $upload_config);
			if ( !$this->upload->do_upload() ) {
				echo sprintf( '<script>parent.alert("%s");</script>', $this->upload->display_errors() );
				//ajaxReturn( $this->upload->display_errors(), '图片上传失败~', 0);
			} else {
				// 上传成功, 处理图片
				$upload_data = $this->upload->data();
				
				$image_config = array(
					'image_library' => 'gd2',
					'source_image' => $upload_data['full_path'],
					'maintain_ratio' => true,
					'width' => 200,
					'height' => 120,
					'create_thumb' => true,
				);
				$this->load->library('image_lib');
				$this->image_lib->initialize( $image_config );
				$this->image_lib->resize();
				
				
				$this->load->model('attach_model');
				$return = array(
					'file' =>  date('/Y/m/d/') . $upload_data['file_name'], // 返回文件的目录+文件名
					'file_thumb' => date('/Y/m/d/') . $upload_data['raw_name'] . '_thumb'. $upload_data['file_ext'], // 目录+纯文件+thumb+后缀
					'attach_id' => $this->attach_model->add_picture( date('/Y/m/d/') . $upload_data['file_name'] ),
				);
				
				
				
				// 处理母“发话”
				$this->load->view('topic/ajax_topic_upload_pic_view', $return );
				
				
				//echo '<script>parent.return_data = "' .$return. '"</script>';
				//echo sprintf('<script>
				//	parent.document.getElementById("add_topic_attach_img_id").setAttribute("value", %d);</script>
				//	', $return['attach_id'] );
				//ajaxReturn( $return, '图片上传成功！', 1 );
			}
			
			
		}
		
		
		/**
		 *	话题附加文件
		 */
		function ajax_topic_upload_file() {
			// 上传的文件目录
			$upload_path = sprintf("%sattach_file/%s", $this->config->item('upload_path'), date('Y/m/d/') ) ; // 根据年月日上传目录
			$this->_createDir($upload_path);
			
			
			$upload_config = array(
				'upload_path' => $upload_path,
				'allowed_types' => 'rar|zip|doc|xls|ppt|txt|pdf|docx|xlsx|pptx', //上传的文件限制
				'max_size' => '4000',
				//'max_width' => '4096',
				//'max_height' => '3000',
				'overwrite' => false,
				//'encrypt_name' => true, // 随机名
			);
			
			$this->load->library('upload', $upload_config);
			if ( !$this->upload->do_upload() ) {
			
				echo sprintf( '<script>parent.alert("%s");</script>', $this->upload->display_errors() );
				//ajaxReturn( $this->upload->display_errors(), '附件上传失败~', 0);
			} else {
				// 上传成功, 处理图片
				$upload_data = $this->upload->data();
				
				$this->load->model('attach_model');
				$return = array(
					'file_name' => $upload_data['file_name'],
					'file' =>  date('/Y/m/d/') . $upload_data['file_name'], // 返回文件的目录+文件名
					'file_thumb' => date('/Y/m/d/') . $upload_data['raw_name'] . '_thumb'. $upload_data['file_ext'], // 目录+纯文件+thumb+后缀
					'file_ext' => $upload_data['file_ext'], // 文件后缀
					'attach_id' => $this->attach_model->add_file( date('/Y/m/d/') . $upload_data['file_name'] ),
				);
				
				// 处理母“发话”
				$this->load->view('topic/ajax_topic_upload_file_view', $return );
				
				
				
				//ajaxReturn( $return, '附件上传成功！', 1 );
			}
			
		}
		
		
	}