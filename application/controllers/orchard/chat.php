<?php

	class Chat extends KK_Controller {
	
		function __construct() {
			parent::__construct();
			
			if ( !is_site_admin() ) {
				exit('admin only');
			}
			
			$this->load->model('chat_model');
		}
		
		function index() {
		
			$start = $this->input->get('start');
			
			$render['start'] = $start;
			$render['chats'] = $this->chat_model->get_all_chats( 20, $start);
			$render['chats_count'] = $this->chat_model->get_all_chats_count();
			
			kk_show_view('orchard/chat/index_view', $render);
		}
	
	}