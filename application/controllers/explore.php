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
			$render['random_groups'] = $this->group_model->get_groups( array(), 12, 0, true );
			$render['fresh_groups'] = $this->group_model->get_fresh_groups( 1, 12 );
			$render['fresh_topics'] = $this->topic_model->get_fresh_topics( 20);
			$render['fresh_events'] = $this->event_model->get_fresh_events( 20);
			
			kk_show_view('explore/index_view', $render);
		}
	
	}