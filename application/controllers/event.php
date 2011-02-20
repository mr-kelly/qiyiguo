<?php

	class Event extends KK_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model('event_model');
		}
		
		function index() {
			$render = array();
			kk_show_view('event/index_view', $render);
		}
		
		
		/**
		 *	活动、任务 查看
		 */
		function event_lookup( $event_id ) {
			$render['event'] = $this->event_model->get_event_by_id( $event_id );
			kk_show_view('event/event_lookup_view', $render);
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
		
	}