<?php
	class Topic extends KK_Controller {
		function __construct() {
			parent::__construct();
			
			if ( !is_site_admin() ) {
				exit('admin only');
			}
			
			$this->load->model('topic_model');
			
		}
		
		function index() {
			
			$start = $this->input->get('start');
			
			
			$render['start'] = $start;
			
			$render['topics'] = $this->topic_model->get_all_topics( 20, $start );
			$render['topics_count'] = $this->topic_model->get_all_topics_count();
			kk_show_view('orchard/topic/index_view', $render);
		}
	
	}