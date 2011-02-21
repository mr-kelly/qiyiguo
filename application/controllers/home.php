<?php
class Home extends KK_Controller {

	function index() {
		
		if ( is_logged_in() ) {
			redirect( 'home/start' );
		}
		$render = array(
			'page_title' => '奇异果 - 发现并创造你的生活',
			'current_home' => 'current_menu',
		);
		
		kk_show_view('home/index_view', $render);
	}
	
	/**
	 *	用户第一次登录成功显示的欢迎页！
	 */
	function start() {
	
		$render = array();
		kk_show_view('home/start_view', $render );
	}
	
	function test() {
		$this->load->model('user_profiles');
		var_dump($this->user_profiles->get_profile());
	}
	
	
	
}