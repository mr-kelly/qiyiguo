<?php
	class Request extends KK_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model('request_model');
			$this->load->model('group_model');
		}
		
		/**
		 *	当前登录用户 作为管理员的group的所有加入请求
		 */
		function index($request_id = null, $action = null) {
			
			if ( is_numeric($request_id) && $action !=null ) {
				// 执行响应
				if ( $action == 'accept') {
					$data = array(
						'status'=>'accept',
					);
					 $this->request_model->update_request_group_by_id($request_id, $data);
					// 执行create_group_user

					// 获取request_group, 为了group_id, user_id
					$request_group = $this->request_model->_get_request($request_id);
					
					//先判断用户是否已经加入友群，没有再加入
					if ( !$this->group_model->is_group_user( $request_group['model_id'], $request_group['user_id'] ) ) {
						$this->group_model->create_group_user( $request_group['model_id'], $request_group['user_id'], null );
						
						ajaxReturn( null, 'accept', 1);
						
						
					} else {
						kk_log( current_url(), 'request重复出现，但用户已加入过了！' );
						ajaxReturn( null, '用户已经加入过了', 0);
					}
					

					
					
				} elseif ( $action == 'reject' ) {
					$data = array( 'status' => 'reject', );
					
					$this->request_model->update_request_group_by_id($request_id, $data);
					// 拒绝后，发短消息通知user
					// TODO
					
					ajaxReturn(null, 'reject', 1 );
					
				} elseif ( $action == 'ignore' ) {
					$data = array( 'status' => 'ignore', );
					
					$this->request_model->update_request_group_by_id($request_id, $data);
					ajaxReturn( null, 'ignore', 1);
				}
				

			}
		
			$user_id = $this->tank_auth->get_user_id();
			$request_groups = $this->request_model->get_request_admin_groups( $user_id , 'admin');
			
			$data= array(
				'request_groups' => $request_groups,
			);
			
			kk_show_view('request/index_view', $data);

		}
		
		
		

	}