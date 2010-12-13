<?php
class Home extends KK_Controller {

	function Home()
	{
		parent::KK_Controller();	
	}
	
	
	function index()
	{
		$data = array(
			'page_title' => '奇异果 / 连接你的友群',
			'current_home' => 'current_menu',
		);
		
		$this->load->view('home/index_view', $data);
	}
	
	function test() {
		$this->load->model('user_profiles');
		var_dump($this->user_profiles->get_profile());
	}
}