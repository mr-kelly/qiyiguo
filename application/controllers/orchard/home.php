<?php

	class Home extends KK_Controller {
		function __construct() {
			parent::__construct();
			

			if ( !is_site_admin() ) {
				exit('admin only');
			}
			
		}
		function index() {
			$render = array();
			kk_show_view('orchard/home/index_view', $render);
		}
		
	}