<?php
class Home extends KK_Controller {

	function index() {
		$this->load->model('group_model');
		$this->load->model('user_mood_model');
		
		
		//$current_ip = $this->input->ip_address();
		$current_ip = '59.38.32.1';
		
		// 59.38.32.*的IP都可以进入！
		if ( ereg( "59\.38\.32\..", $current_ip ) ) {
			//echo 'bnu';
		}
		
		// 限制BNU Only
		if ( $this->config->item('restrict_bnu') ) {
			if ( ! isset( $_GET['kk'] ) ) {
				

				
				kk_show_view('home/bnu_only');
				return;
			}
		}
		
		// 登錄了的人轉到開始頁...
		if ( is_logged_in() ) {
			redirect( 'home/start' );
		}
		
		$random_users = $this->user_profiles_model->get_users( array(), 24, 0, true); // 随机用户~~
		
		// 添加用户Mood
		foreach( $random_users as $key=>$random_user ) {
			$random_users[$key]['Mood'] = $this->user_mood_model->get_user_last_mood( $random_user['id'] );
		}
		
		$render = array(
			'random_groups' => $this->group_model->get_groups( array(), 18, 0, true ), // 随机~~
			'random_users' => $random_users,
			'page_title' => '奇异果 - 发现并创造你的生活',
			'current_home' => 'current_menu',
		);
		
		kk_show_view('home/index_view', $render);
	}
	
	/**
	 *	用户第一次登录成功显示的欢迎页！
	 */
	function start() {
		login_redirect();
		$this->load->library('KK_Inner_Index'); //当前帐号内涵指数
		$this->load->model('group_model');
		$this->load->model('stream_model');
		
		// 他妈的，提示用户别用IE6了！
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false ) {
			$this->session_message->set( '嘿，奇异果发现你还在使用IE6内核的落后浏览器，部分奇异果的功能你将不能使用。天啊，赶快去..<a target="_blank" href="http://www.google.com/chrome">&gt;下载先进浏览器吧</a>');
		}
		
		
		
		$render['page_title'] = sprintf( "%s - 开始奇异果!", get_current_user_name() );
		$render['current_user_home'] = 'current_menu';
		
		
		$render['user_inner_index'] = $this->kk_inner_index->get_inner_index( get_current_user_profile() );
		
		// 获取用户关注群组的topics
		$render['user_groups_topics'] = $this->stream_model->get_user_groups_topics( get_current_user_id(), 10, 0 );
		
		// 获取用户关注群组的events...
		$render['user_groups_events'] = $this->stream_model->get_user_groups_events( get_current_user_id(), 10, 0 );
		
		
		$render['user_groups'] = $this->group_model->get_user_groups( get_current_user_id(), 1000 );
		$render['user_groups_count'] = $this->group_model->get_user_groups_count( get_current_user_id() );
		
		$render['user_admin_groups'] = $this->group_model->get_user_admin_groups( get_current_user_id() , 1000);
		$render['user_admin_groups_count'] = $this->group_model->get_user_admin_groups_count( get_current_user_id() );
		
		// 如果用户没有管理群， 显示推荐
		if ( empty( $render['user_admin_groups'] ) ) {
			$render['random_groups'] = $this->group_model->get_groups( array(), 10, 0, true );
		}
		
		kk_show_view('home/start_view', $render );
	}
	
	function test() {
		phpinfo();
		$this->load->model('user_profiles');
		var_dump($this->user_profiles->get_profile());
	}
	
	
	
}
