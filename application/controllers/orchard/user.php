<?php

	class User extends KK_Controller {
		function __construct() {
			parent::__construct();
			
			if ( !is_site_admin() ) {
				exit('admin only');
			}
			
			$this->load->model('user_profiles_model');
		}
		
		function index() {
			$start = $this->input->get('start');
			
			$render['start'] = $start;
			
			$render['users_count'] = $this->user_profiles_model->get_users_count();
			
			$render['users'] = $this->user_profiles_model->get_users( array(), 20, $start);
			kk_show_view('orchard/user/index_view', $render);
		}
		
		function create_user() {
			$this->load->library('Tank_auth');
			$render = array();
			
			if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				$this->form_validation->set_rules( 'id',	'群号', 'trim|required|xss_clean|min_length[5]');
				$this->form_validation->set_rules( 'email',	'电邮', 'trim|required|xss_clean|valid_email');
				$this->form_validation->set_rules( 'password',	'密码', 'trim|required|xss_clean');
				$this->form_validation->set_rules( 'role', '用户角色', 'trim|xss_clean');
				
				if ( !$this->form_validation->run() ) {
					$render['message'] = validation_errors();
				} else {
					// 创建用户吧
					$new_user_id = $this->form_validation->set_value('id');
					$email = $this->form_validation->set_value('email');
					$password = $this->form_validation->set_value('password');
					$role = $this->form_validation->set_value('role'); // 用户角色： admin, editor,   ''(普通用户)
					
					if ( $this->tank_auth->create_user( $email, $email, $password, FALSE, $new_user_id, $role ) ) {
						// New User ID是需要自定义的用户ID～
						// 创建用户成功...
						// 创建profile~
						$this->user_profiles_model->create_user_profile( $new_user_id, array(
								
						));
						
						// 成功提示～
						$render['message'] = sprintf( '用户创建成功！果号是: %s, 邮箱是: %s~ 去登录吧~ ', $new_user_id, $email );
					} else {
					
						$render['message'] = '创建用户失败！可能邮箱、果号重复了！';
						
					}
					
					
					
				}
			}
			
			
			
			kk_show_view('orchard/user/create_user_view', $render);
		}
		
		
	}
