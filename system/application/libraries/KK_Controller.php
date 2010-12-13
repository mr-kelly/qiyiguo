<?php
	class KK_Controller extends Controller {
		function __construct() {

			parent::Controller();
			
			// 让?xxx=xxx  生效$_GET
			parse_str($_SERVER['QUERY_STRING'],$_GET); 
			
		}
		function KK_Controller() {
			$this->__construct();
		}
		
		
	}