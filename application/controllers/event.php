<?php

	class Event extends KK_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model('event_model');
		}
		
		function index() {
			$render['page_title'] = '奇异果的公开群组活动';
			$render['current_event'] = 'current_menu';
			$render['events'] = $this->event_model->get_events_custom( array() );
			kk_show_view('event/index_view', $render);
		}
		
		
		/**
		 *	编辑活动
		 */
		function edit( $event_id ) {
			login_redirect();
			
			$event = $this->event_model->get_event_by_id( $event_id );
			
			
			// 活动发布者才能修改
			if ( $event['user_id'] != get_current_user_id() ) {
				exit( 'event creator only!' );
			}
			
			
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			
				$this->form_validation->set_rules('create_event_start_year','活动开始年份', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_start_month','活动开始月份', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_start_day','活动开始日子', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_start_hour', '活动开始小时', 'trim|required|xss_clean|integer');
				$this->form_validation->set_rules('create_event_start_min', '活动开始分钟', 'trim|required|xss_clean|integer');
				
				//$this->form_validation->set_rules('create_event_end_date', '活动结束日期', 'trim|required|xss_clean|alpha_dash');
				
				$this->form_validation->set_rules('create_event_end_year', '活动结束年份', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_end_month', '活动结束月份', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_end_day', '活动结束日子', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_end_hour', '活动结束小时', 'trim|required|xss_clean|integer');
				$this->form_validation->set_rules('create_event_end_min', '活动结束分钟', 'trim|required|xss_clean|integer');
				
				$this->form_validation->set_rules('create_event_name', '活动名称', 'trim|required|xss_clean|max_length[20]');
				$this->form_validation->set_rules('create_event_content', '活动简介', 'trim|required|xss_clean');
				
				
				if ( ! $this->form_validation->run() ) {
					// 不通过表单验证~
					ajaxReturn ( null, validation_errors() , 0 );
				} else {
				
					//$event_group_id = $this->form_validation->set_value('event_group_id');
					
					// 活动开始时间
					$create_event_start_date = sprintf('%s-%s-%s', $this->form_validation->set_value('create_event_start_year'), $this->form_validation->set_value('create_event_start_month'), $this->form_validation->set_value('create_event_start_day'));
					$create_event_start_hour = $this->form_validation->set_value('create_event_start_hour');
					$create_event_start_min = $this->form_validation->set_value('create_event_start_min');
					
					$create_event_start = $create_event_start_date . ' '. $create_event_start_hour . ':' . $create_event_start_min . ':00';
					
					
					// 活动结束时间
					$create_event_end_date = sprintf('%s-%s-%s', $this->form_validation->set_value('create_event_end_year'), $this->form_validation->set_value('create_event_end_month'), $this->form_validation->set_value('create_event_end_day'));
					$create_event_end_hour = $this->form_validation->set_value('create_event_end_hour');
					$create_event_end_min = $this->form_validation->set_value('create_event_end_min');
					
					$create_event_end = $create_event_end_date . ' '. $create_event_end_hour . ':' . $create_event_end_min . ':00';
					
					// 活动开始时间不能大于结束时间
					if ( $create_event_start > $create_event_end ) {
						ajaxReturn( null, '活动时间错误', 0 );
					}
					
					$create_event_name = $this->form_validation->set_value('create_event_name');
					$create_event_content = $this->form_validation->set_value('create_event_content');
					
					
					
					
					$this->load->model('event_model');
					$update_event = $this->event_model->update_event($event_id, array(
						
						'start' => $create_event_start,
						'end' => $create_event_end,
						'name' => $this->kk_filter->filter( $create_event_name ),
						'content' => $this->kk_filter->filter( $create_event_content ),
						//'model' => $model,
						//'model_id' => $model_id,
						'user_id' => $this->tank_auth->get_user_id(),
						
					));
					
					$this->session_message->set( '已修改活动' );
					redirect( 'event/' . $event_id );
					
					//ajaxReturn('ok', '已成功修改活动', 1);
				}
			}
			
			
			
			$render['event'] = $event;
			$render['event_id'] = $event_id;
			kk_show_view('event/edit_view', $render);
			
		}
		
		
		/**
		 *	活动、任务 查看
		 */
		function event_lookup( $event_id ) {
			
			up_event_page_view( $event_id );
			
			clean_notices( get_current_user_id(), 'event', $event_id );
			
			$event = $this->event_model->get_event_by_id( $event_id );
			if ( !$event ) {
				show_404();
			}
			
			// 判断话题所属群组是否是私有群组， 
			$event_group = kk_get_group( $event['model_id'] );
			if ( $event_group['privacy'] == 'private' ) {
				// 如果是，判断是否为群组成员，成员才可以查看
				if ( !is_group_user( $event_group['id'], get_current_user_id() )) {
					$render['group'] = $event_group;
					$render['event'] = $event;
					kk_show_view( 'event/event_forbidden_view', $render );
					return;
				}
			}
			
			$render['page_title'] = $event['name'];
			$render['current_event'] = 'current_menu';
			$render['event'] = $event;
			
			$render['event_users'] = $this->event_model->get_event_users( $event_id, false );
			// 关注人数（ 参与+感兴趣）
			$render['event_users_count'] = $this->event_model->get_event_users_count( $event_id, false);
			
			$render['event_join_users_count'] = $this->event_model->get_event_users_count( $event_id, 'join');
			$render['event_join_users'] = $this->event_model->get_event_users( $event_id );
			
			kk_show_view('event/event_lookup_view', $render);
		}
		
		
		/**
		 *	获取当前用户的任务.. (来自私有群组)
		 */
		function my_missions() {
			$render['page_title'] = '我的任务';
			$render['current_event'] = 'current_menu';
			kk_show_view('event/my_missions_view', $render);
		}
		
		

		
		/**
		 *	创建事情页。  显示很多群组...
		 */
		function add_event() {
			login_redirect();
			$this->load->model('group_model');
			
			$render['page_title'] = '选择一个群组， 创建活动或任务';
			$render['add_events_user_groups'] = $this->group_model->get_user_groups( get_current_user_id() , null );
			
			kk_show_view( 'event/add_event_view', $render );
		}
		
		/**
		 *	加入的群的话题 (群话题 )
		 */
		function my_events() {
			login_redirect();
			login_redirect();
			
			$this->load->model( 'stream_model' );
			
			$start = $this->input->get( 'start' );
			$per_page = 20; // 每页显示...
			
			
			$render['page_title'] = '我的群组话题';
			$render['start'] = $start;
			$render['per_page'] = $per_page;
			$render['current_event']= 'current_menu';
			$render['my_events_count'] = $this->stream_model->get_user_groups_events_count( get_current_user_id() );
			
			// 获取用户关注群组的events
			$render['user_groups_events'] = $this->stream_model->get_user_groups_events( get_current_user_id(), $per_page, $start );
			
			// 获取用户组织的活动
			$render['user_events'] = $this->event_model->get_user_events( get_current_user_id(), 5 );
			
			
			$render['current_event'] = true;
			kk_show_view('event/my_events_view', $render);
			
		}
		
		
		/**
		 *	用户参加某活动、任务
		 */
		function ajax_join_event( $event_id, $action = 'join' ) {
			if ( !is_logged_in() ) {
				ajaxReturn( 'login_required', '未登录', 0 );
			}
			
			$event = $this->event_model->get_event_by_id( $event_id );
			
			if ( $action == 'join' ) {
			
				if ( $event_user_id = $this->event_model->create_event_user( $event_id, get_current_user_id(), 'join' ) ) {
					// 参加活动后，notice组织者!!!
					if ( $event['user_id'] != get_current_user_id() ) {
						add_notice( $event['user_id'],
									'你组织的活动有新人参与',
									sprintf('%s参与了你的活动', get_current_user_name() ),
									sprintf('/%s/%s', 'event', $event_id),
									'event',
									$event_id,
									'join_event'
						);
					}
					
					ajaxReturn( null, '成功参加了这该活动~', 1);
					
				} else {
					ajaxReturn( null, '貌似你已经是参加者了', 0 );
				}
				
				
				
			} else if ( $action == 'exit' ) {
				
				// 退出参加某活动
				if ( $this->event_model->del_event_user( array(
															'event_id' => $event_id,
															'user_id' => get_current_user_id(),
															'type' => 'join',
															)) ) {
					ajaxReturn( null, '退出了这场活动', 1 );
				} else {
					ajaxReturn( null, '错误，无法退出这场活动', 0 );
				}
				
			}

		}
		
		/**
		 *	用户关注、感兴趣某活动
		 */
		function ajax_follow_event( $event_id, $action = 'follow' ) {
			
			if ( !is_logged_in() ) {
				ajaxReturn( 'login_required', '未登录', 0 );
			}
			
			if ( $action == 'follow' ) {
				
				if ( $event_user_id = $this->event_model->create_event_user( $event_id, get_current_user_id(), 'follow' ) ) {
					
					ajaxReturn( null, '你已对这个活动表示兴趣', 1 );
				} else {
					ajaxReturn( null, '错误:无法对其有兴趣', 0 );
				}
				
			} else if ( $action == 'unfollow' ) {
				// 删除对应事件
				if ( $this->event_model->del_event_user( array( 
															'event_id' => $event_id,
															'user_id' => get_current_user_id(),
															'type' => 'follow',
															)) ) {
															
					ajaxReturn( null, '对这个活动失去了兴趣', 1 );
				} else {
					ajaxReturn( null, '错误:无法对其失去兴趣', 0 );
				}
				
			}
		}
		
		
		
		
		
		
		/**
		 *	Ajax 添加 友群活动
		 */
		function ajax_create_event($model, $model_id) {
		
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				
				//$this->form_validation->set_rules('event_group_id', '活动对应的群号', 'trim|required|xss_clean|integer');
				
				//$this->form_validation->set_rules('create_event_start_date','活动开始日期', 'trim|required|xss_clean|alpha_dash');
				
				$this->form_validation->set_rules('create_event_start_year','活动开始年份', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_start_month','活动开始月份', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_start_day','活动开始日子', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_start_hour', '活动开始小时', 'trim|required|xss_clean|integer');
				$this->form_validation->set_rules('create_event_start_min', '活动开始分钟', 'trim|required|xss_clean|integer');
				
				//$this->form_validation->set_rules('create_event_end_date', '活动结束日期', 'trim|required|xss_clean|alpha_dash');
				
				$this->form_validation->set_rules('create_event_end_year', '活动结束年份', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_end_month', '活动结束月份', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_end_day', '活动结束日子', 'trim|required|xss_clean|alpha_dash');
				$this->form_validation->set_rules('create_event_end_hour', '活动结束小时', 'trim|required|xss_clean|integer');
				$this->form_validation->set_rules('create_event_end_min', '活动结束分钟', 'trim|required|xss_clean|integer');
				
				$this->form_validation->set_rules('create_event_name', '活动名称', 'trim|required|xss_clean|max_length[20]');
				$this->form_validation->set_rules('create_event_content', '活动简介', 'trim|required|xss_clean');
				
				$this->form_validation->set_rules('attach_img_id','附加图片', 'integer|xss_clean|trim');
				
				if ( ! $this->form_validation->run() ) {
					// 不通过表单验证~
					ajaxReturn ( null, validation_errors() , 0 );
				} else {
				
					//$event_group_id = $this->form_validation->set_value('event_group_id');
					
					// 活动开始时间
					$create_event_start_year = $this->form_validation->set_value('create_event_start_year');
					$create_event_start_month = $this->form_validation->set_value('create_event_start_month');
					$create_event_start_day =  $this->form_validation->set_value('create_event_start_day');
					
					$create_event_start_date = sprintf('%s-%s-%s', $create_event_start_year , $create_event_start_month , $create_event_start_day);
					$create_event_start_hour = $this->form_validation->set_value('create_event_start_hour');
					$create_event_start_min = $this->form_validation->set_value('create_event_start_min');
					
					$create_event_start = $create_event_start_date . ' '. $create_event_start_hour . ':' . $create_event_start_min . ':00';
					
					
					// 活动结束时间
					$create_event_end_year = $this->form_validation->set_value('create_event_end_year');
					$create_event_end_month = $this->form_validation->set_value('create_event_end_month');
					$create_event_end_day = $this->form_validation->set_value('create_event_end_day');
					
					$create_event_end_date = sprintf('%s-%s-%s', $create_event_end_year, $create_event_end_month, $create_event_end_day);
					$create_event_end_hour = $this->form_validation->set_value('create_event_end_hour');
					$create_event_end_min = $this->form_validation->set_value('create_event_end_min');
					
					$create_event_end = $create_event_end_date . ' '. $create_event_end_hour . ':' . $create_event_end_min . ':00';
					
					// 活动开始时间不能大于结束时间
					// 如果日期
					//if ( $create_event_start_day > $create_event_end_day ||
					//		$create_event_start_month > $create_event_end_month ||
					//			$create_event_start_year > $create_event_end_year ) {
					if ( strtotime($create_event_start) > strtotime($create_event_end) ) {			
						ajaxReturn( null, '活动时间错误', 0 );
					}
					
					$create_event_name = $this->kk_filter->filter( $this->form_validation->set_value('create_event_name') );
					$create_event_content = $this->kk_filter->filter( $this->form_validation->set_value('create_event_content') );
					
					
					
					
					$this->load->model('event_model');
					$event_id = $this->event_model->create_event( array(
						
						'start' => $create_event_start,
						'end' => $create_event_end,
						'name' => $this->kk_filter->filter( $create_event_name ),
						'content' => $this->kk_filter->filter( $create_event_content ),
						'model' => $model,
						'model_id' => $model_id,
						'user_id' => $this->tank_auth->get_user_id(),
						
						
						'attach_img_id' => $this->form_validation->set_value('attach_img_id'),
						
					));
					
					
					// 活动创建成功。 组织者自动参加！
					$this->event_model->create_event_user( $event_id, get_current_user_id() );
					
					ajaxReturn('ok', '已成功创建活动', 1);
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
		 *	ajax 获取按钮
		 */
		function ajax_get_event_join_btn( $event_id ) {
			$render['event'] = $this->event_model->get_event_by_id( $event_id );
			kk_show_view('event/general_event_join_btn', $render);
		}
		
		
		/**
		 *	删除 活动、任务
		 */
		function ajax_delete( $event_id ) {
			if ( !is_logged_in() ) {
				ajaxReturn('login_required', '未登录', 0 );
			}
			
			// 获取事件，判断当前用户是否是 事件群组管理者或组织者
			$event = $this->event_model->get_event_by_id( $event_id );
			
			if ( is_group_admin( $event['model_id'], get_current_user_id() ) ||
					get_current_user_id() == $event['user_id'] ) {
				
				if ( $this->event_model->del_event( $event_id ) ) {
					ajaxReturn( null, '成功删除这件事', 1 );
				} else {
					ajaxReturn( null, '无法删除这件事', 0 );
				}
						
				
			} else {
				ajaxReturn( null, '你不够权限', 0);
			}
					

		}
		
		/**
		 *	上传活动图片
		 */
		function ajax_event_upload_pic() {
			
			
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
				$this->load->view('event/ajax_event_upload_pic_view', $return );
				
				
				//echo '<script>parent.return_data = "' .$return. '"</script>';
				//echo sprintf('<script>
				//	parent.document.getElementById("add_topic_attach_img_id").setAttribute("value", %d);</script>
				//	', $return['attach_id'] );
				//ajaxReturn( $return, '图片上传成功！', 1 );
			}
			
			
		}
		
	}