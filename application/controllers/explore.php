<?php

	class Explore extends KK_Controller {
	
		/**
		 *	探索 首页~~
		 */
		function index() {
			$this->load->model('group_model');
			$this->load->model('topic_model');
			$this->load->model('event_model');
			
			$render['current_explore'] = true;
			$render['fresh_groups'] = $this->group_model->get_fresh_groups( 5 );
			$render['fresh_topics'] = $this->topic_model->get_fresh_topics();
			$render['fresh_events'] = $this->event_model->get_fresh_events();
			
			kk_show_view('explore/index_view', $render);
		}
	
	}