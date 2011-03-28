<?php

	class Terminal extends KK_Controller {
	
		function index() {
			$query = $this->db->get('ci_sessions'); 
			$render['users_online'] = $query->result_array();
			
			kk_show_view('terminal/index_view', $render);
		}
	}