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
		
	}