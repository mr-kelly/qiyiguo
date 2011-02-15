<?php

	class User extends KK_Controller {
		function create_user() {
			
			$data = array();
			kk_show_view('orchard/user/create_user_view', $data);
		}
		
		
	}