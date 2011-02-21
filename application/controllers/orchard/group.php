<?php

	class Group extends KK_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model('group_model');
		}
		function index() {
			$render['groups'] = $this->group_model->get_groups();
			kk_show_view('orchard/group/index_view', $render);
		}
		
		function group_lookup( $group_id ) {
			$render['group'] = $this->group_model->get_group_by_id( $group_id );
			kk_show_view('orchard/group/group_lookup_view', $render);
		}
		
		function delete( $group_id ) {
			
		}
		
	}
