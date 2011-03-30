<?php

	class Group extends KK_Controller {
		function __construct() {
			parent::__construct();
			
			if ( !is_site_admin() ) {
				exit('admin only');
			}
			
			$this->load->model('group_model');
		}
		function index() {
			$start = $this->input->get('start');
			
			$render['start'] = $start;
			$render['groups'] = $this->group_model->get_groups( array(), 20, $start );
			$render['groups_count'] = $this->group_model->get_groups_count();
			
			kk_show_view('orchard/group/index_view', $render);
		}
		
		function group_lookup( $group_id ) {
			$render['group'] = $this->group_model->get_group_by_id( $group_id );
			kk_show_view('orchard/group/group_lookup_view', $render);
		}
		
		function create_group() {
			
			if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				$this->form_validation->set_rules( 'id',	'果群号', 'trim|required|xss_clean|min_length[5]');
				$this->form_validation->set_rules( 'name',	'果群名', 'trim|required|xss_clean');
				$this->form_validation->set_rules( 'category_id',	'群类型', 'trim|required|xss_clean');
				$this->form_validation->set_rules( 'role', '用户角色', 'trim|xss_clean');
				
				$this->form_validation->set_rules( 'group_privacy', '公开程度', 'trim|xss_clean');
				$this->form_validation->set_rules( 'group_verify', '加入验证方方式', 'xss_clean');
				$this->form_validation->set_rules( 'owner_id', '创始人果号', 'required|trim|xss_clean');
				
				//$this->form_validation->set_rules( 'owner_id', '创始人ID', 'trim|xss_clean');
				
				if ( !$this->form_validation->run() ) {
					$render['message'] = validation_errors();
				} else {
					// 创建群组吧
					$group_id = $this->form_validation->set_value('id');
					
					$name = $this->form_validation->set_value('name');
					$group_privacy = $this->form_validation->set_value('group_privacy');
					$group_verify = $this->form_validation->set_value('group_verify');
					$owner_id = $this->form_validation->set_value('owner_id');
					
					if ( $group_privacy == 'public' ) {
						$group_verify = 'everyone';
					}
					
					
					
					if ( $this->group_model->create_group( array(
																'id' => $group_id,
																'name' => $name,
																'privacy' => $group_privacy,
																'verify' => $group_verify,
																'owner_id' => $owner_id,
															))) {
						
						$render['message'] = sprintf('群创建成功！');
						
					} else {
						$render['message'] = sprintf('群创建失败,可能ID重复了？');
					}
// 					if ( $this->tank_auth->create_user( $email, $email, $password, FALSE, $new_user_id, $role ) ) {
// 						// New User ID是需要自定义的用户ID～
// 						// 创建用户成功...
// 						// 创建profile~
// 						$this->user_profiles_model->create_user_profile( $new_user_id, array(
// 								
// 						));
// 						
// 						// 成功提示～
// 						$render['message'] = sprintf( '用户创建成功！果号是: %s, 邮箱是: %s~ 去登录吧~ ', $new_user_id, $email );
// 					} else {
// 					
// 						$render['message'] = '创建用户失败！可能邮箱、果号重复了！';
// 						
// 					}
					
					
					
				}
			}
			
			$render['group_categories'] = $this->group_model->get_group_categories( array(
					'parent_id' => 0,
			));
			kk_show_view('orchard/group/create_group_view', $render);
		}
		
		
		function delete( $group_id ) {
			
		}
		
	}
