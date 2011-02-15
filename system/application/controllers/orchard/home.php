<?php

	class Home extends KK_Controller {
	
		function index() {
			$render = array();
			kk_show_view('orchard/home/index_view', $render);
		}
		
	}