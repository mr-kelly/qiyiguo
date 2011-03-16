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
			
				
				// 获取该request...
				$request = $this->request_model->get_request_by_id( $request_id );
				$group = kk_get_group( $request['model_id'] ); // request对应的group
				
				/**
				 *	用户请求加入群组的处理
				 
				 		同意 - 把request 删除了
				 		拒绝 - request删除，并提醒
				 		忽略 - reuqets删除，不提示
				 */
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
						
						add_notice( $request['user_id'], '加入群组',
									sprintf( '你成功加入了群组「%s」',  $group['name'] ) , 
									sprintf( '/group/%s', $request['model_id'] ),
									'group',
									$request['model_id']);
						ajaxReturn( null, 'accept', 1);
						
						
					} else {
						kk_log( current_url(), 'request重复出现，但用户已加入过了！' );
						ajaxReturn( null, '用户已经加入过了', 0);
					}
					

					
					
				} elseif ( $action == 'reject' ) {
					$data = array( 'status' => 'reject', );
					
					$this->request_model->update_request_group_by_id($request_id, $data);
					// 拒绝后 通知user
					add_notice( $request['user_id'], '被拒绝',
								sprintf( '你被群组%s拒绝了加入',  $group['name']  ), 
								sprintf( '/group/%s', $request['model_id'] ),
								'group',
								$request['model_id']);
					
					ajaxReturn(null, '拒绝了他加入', 1 );
					
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
				'request_groups_count' => $this->request_model->get_request_admin_groups_num( $user_id ),
			);
			
			kk_show_view('request/index_view', $data);

		}
		
		
		

	}