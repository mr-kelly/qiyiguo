<?php

	class Event extends KK_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model('event_model');
		}
		
		function index() {
			$render['events'] = $this->event_model->get_events_custom( array() );
			kk_show_view('event/index_view', $render);
		}
		
		
		/**
		 *	活动、任务 查看
		 */
		function event_lookup( $event_id ) {
			$render['event'] = $this->event_model->get_event_by_id( $event_id );
			$render['event_users'] = $this->event_model->get_event_users( $event_id );
			$render['event_join_users_count'] = $this->event_model->get_event_users_count( $event_id, 'join');
			// 关注人数（ 参与+感兴趣）
			$render['event_users_count'] = $this->event_model->get_event_users_count( $event_id, false);
			
			kk_show_view('event/event_lookup_view', $render);
		}
		
		
		
		/**
		 *	用户参加某活动、任务
		 */
		function ajax_join_event( $event_id, $action = 'join' ) {
			if ( !is_logged_in() ) {
				ajaxReturn( null, '未登录', 0 );
			}
			
			if ( $action == 'join' ) {
			
				if ( $event_user_id = $this->event_model->create_event_user( $event_id, get_current_user_id(), 'join' ) ) {
					// TODO 参加活动后，notice用户!!!
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
				ajaxReturn( null, '未登录', 0 );
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
				
				$this->form_validation->set_rules('create_event_name', '活动名称', 'trim|required|xss_clean');
				$this->form_validation->set_rules('create_event_content', '活动简介', 'trim|required|xss_clean');
				
				
				if ( ! $this->form_validation->run() ) {
					// 不通过表单验证~
					AjaxReturn ( null, validation_errors() , 0 );
				} else {
				
					//$event_group_id = $this->form_validation->set_value('event_group_id');
					
					$create_event_start_date = sprintf('%s-%s-%s', $this->form_validation->set_value('create_event_start_year'), $this->form_validation->set_value('create_event_start_month'), $this->form_validation->set_value('create_event_start_day'));
					$create_event_start_hour = $this->form_validation->set_value('create_event_start_hour');
					$create_event_start_min = $this->form_validation->set_value('create_event_start_min');
					
					$create_event_end_date = sprintf('%s-%s-%s', $this->form_validation->set_value('create_event_end_year'), $this->form_validation->set_value('create_event_end_month'), $this->form_validation->set_value('create_event_end_day'));
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
						'model' => $model,
						'model_id' => $model_id,
						'user_id' => $this->tank_auth->get_user_id(),
						
					));
					
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
		
	}