<?php
	/**
	 *	邀请朋友加入 （MSN邮箱、微博）
	 */
	class Invite extends KK_Controller {
	
		function index() {
			$render = array();
			kk_show_view('invite/index_view', $render);
		
		}
	}