<?php

	class User extends KK_Controller {
		function create_custom_user() {
			
			$data = array();
			kk_show_view('orchard/user/create_custom_user_view', $data);
		}
		
		
	}