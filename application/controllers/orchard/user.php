<?php

	class User extends KK_Controller {
		function index() {
			$render = array();
			kk_show_view('orchard/user/index_view', $render);
		}
		
		function create_user() {
			$render = array();
			
			if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				$this->form_validation->set_rules( 'id',	'群号', 'trim|required|xss_clean|min_length[6]');
				$this->form_validation->set_rules( 'email',	'电邮', 'trim|required|xss_clean');
				$this->form_validation->set_rules( 'password',	'密码', 'trim|required|xss_clean');
				
				if ( !$this->form_validation->run() ) {
					$render['message'] = validation_errors();
				}
			}
			
			
			
			kk_show_view('orchard/user/create_user_view', $render);
		}
		
		
	}