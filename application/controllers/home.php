<?php
class Home extends KK_Controller {

	function index() {
		$this->load->model('group_model');
		$this->load->model('user_mood_model');
		
		// 限制BNU Only
		if ( $this->config->item('restrict_bnu') ) {
			if ( ! isset( $_GET['ilovemrkelly'] ) ) {
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
		
		kk_show_view('home/start_view', $render );
	}
	
	function test() {
		phpinfo();
		$this->load->model('user_profiles');
		var_dump($this->user_profiles->get_profile());
	}
	
	
	
}
