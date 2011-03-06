<?php
	
	/**
	 *	未登录，转移到登录页，登录后返回登录请求页面
	 */
    function login_redirect($url = '') {
    	$ci =& get_instance();
    	if ( !$ci->tank_auth->is_logged_in() ) {
    		// 未登录
    		redirect('user/login?redirect=' . uri_string() );
    	}
    }
	
	/**
	 *	判断是否登录了
	 */
	function is_logged_in() {
		$ci =& get_instance();
		return $ci->tank_auth->is_logged_in();
	}
	
	
	function get_current_user_id() {
		//login_redirect();
		$ci =& get_instance();
		return $ci->tank_auth->get_user_id();
	}

	function kk_log($url, $message) {
		$ci =& get_instance();
		$ci->log_model->create_log($url, $message);
	}
	
	/**
	 *	获取当前用户的
	 */
	function get_user_option( $key ) {
		$ci =& get_instance();
		$ci->load->model('user_option_model');
		$option_value = $ci->user_option_model->get_user_option( get_current_user_id(), $key );
		
		return $option_value;
	}
	
	
	
	/**
	 *	获取用户关系 - mutual, follow, fans, none
	 */
	function get_user_relation( $to_user_id, $from_user_id ) {
		$ci =& get_instance();
		$ci->load->model('relation_model');
		return $ci->relation_model->get_user_relation( $to_user_id, $from_user_id );
	}
	
	
	
	/**
	 *	Ajax, URL,登录
	 */

	
	// 未登录，弹出登录窗口
	function show_login_box() {
		echo "
		<script>
			$(function(){
				$('#login_btn').trigger('click');
			});
		</script>
		";
	}


	// 若存在site_url，则证明已经开启URL Helper
	if ( function_exists( 'site_url') ) {
		
		/**
		 *	读取static文件夹里的静态文件~   
		 
		 		$file可选
		 */
		function static_url( $file='' ) {
			$CI =& get_instance();
			
			// 如果static是http://xxxxx,那么直接返回这网址
			if ( preg_match('#^https?://#i', $CI->config->item('static_url') ))
			{
				return $CI->config->item('static_url') . $file;
			}
			
			
			return $CI->config->site_url( $CI->config->item('static_url') . $file );
		}
		
	}
	

	
	
	
	// KK AjaxReturn, return json and exit
	if ( !function_exists('ajaxReturn')) {
	
		function ajaxReturn($data, $info, $status) {
			$arr = array(
				'data' => $data, 
				'info' => $info,
				'status' => $status,
			);
			
			//header("Content-type: text/javascript");
						
			echo json_encode($arr);
			exit();
			
		}
	}
	
	
	// import JS
	if ( !function_exists('import_js')) {
		function import_js($href) {

			return sprintf('<script type="text/javascript" src="%s"></script>', static_url( $href ));
		}
	}
	
	// import CSS
	
	function import_css($href) {
		
		return sprintf('<link rel="stylesheet" type="text/css" media="all" href="%s" /> ', static_url( $href ));
	}
	
	
	/**
	 *  获得当前用户，以数组形式返回
	 *  可选参数$which, 返回用户的哪项资料
	 *  若未登陆，返回null
	 */
	if ( !function_exists('get_current_user_profile')) {
	
		function get_current_user_profile( $which=null ) {
			$KK =& get_instance();
			$current_user_id = $KK->tank_auth->get_user_id();
			
			// 通过user_profiles Model 取得当前用户资料全数组
			$arr = $KK->user_profiles_model->get_profile($current_user_id);
			
			// 如果不传递参数，返回整个profile
			if ( empty( $which ) ) {
				return $arr;
			}
			
			
			//return $arr[$which];
			if ( isset( $arr[$which] ) ) {
				return $arr[$which];
			} else {
				return false;
			}
		}
		
	}
	
	
	
	/**
	 *	智能获取用户的称呼
	 		没设置realname用nickname，没nickname，用email
	 */
	function get_current_user_name() {
		return get_current_user_profile('name');
// 		$realname = get_user_profile('realname');
// 		$nickname = get_user_profile('nickname');
// 		$email = get_user_profile('email');
// 		
// 		if ( $realname == '') {
// 			if ( $nickname == '' ) {
// 				return $email;
// 			} else {
// 				return $nickname;
// 			}
// 		} else {
// 			return $realname;
// 		}
// 		return $email;
	}
	
	function get_user_name( $nickname, $realname ) {
		return sprintf('%s <span class="small">(%s)</span>', $nickname , $realname ); 
	}
	
	
	/**
	 *	获得用户的页面网址（个人网址slug)
	 */
	function get_user_url( $user_id ) {
		$ci =& get_instance();
		$slug = $ci->user_profiles_model->get_user_slug( $user_id );
		
		if ( $slug ) {
			// 存在个人网址
			return site_url('u/' . $slug );
		} else {
			// 不存在个人网址 slug == false
			return site_url('u/' . $user_id );
		}
	}
	
	/**
	 *	获取群组的链接
	 */
	function get_group_url( $group_id ) {
		$ci =& get_instance();
		$group = $ci->group_model->_get_group( $group_id ) ;
		
		$group_slug = $group['slug'];
		
		if ( $group_slug ) {
			// 群组存在自定义网址
			return site_url( 'g/' . $group_slug );
		} else {
			// 群组没有设置自定义网址，  传递ID网址
			return site_url( 'g/' . $group_id );
		}
	}
	/**
	 *	获取指定用户的头像网址, 可选指定用户id,  
	 		$big为是否返回原始图，大头像！～
	 */
	function get_user_avatar_url($user_id = null, $big=false) {

		
		$ci =& get_instance();
		if ( $user_id === null ) {
			$user_id = $ci->tank_auth->get_user_id();
		}
		
		$ci->load->model('user_profiles_model');
		$profile = $ci->user_profiles_model->get_profile($user_id);
		
		

		
		// 用户是否存在头像
		if ( isset( $profile['Avatar'] ) ) {
		
				if ( $big == false ) {
					// 没指定要原大图，返回缩略图地址
					return static_url( 'upload/avatars/'. $user_id. '/' . $profile['Avatar']['avatar_thumb'] );
				} elseif ( $big == true ) {
					// 返回大图
					return static_url( 'upload/avatars/'. $user_id. '/' . $profile['Avatar']['avatar_file'] );
				}
			
		} else {
			// 用户尚未设置头像，显示空头像...
			return static_url( 'img/default_avatar.jpg' );
		}
	}
	
	
	/**
	 *	获取友群的标志，
	 		如果没设置标志，显示默认图像
	 */
	function get_group_logo_url($group_id) {
		$ci =& get_instance();
		$ci->load->model('group_model');
		
		if ( $ci->group_model->is_group_logo( $group_id ) ) {
			// 有logo显示logo地址
			return static_url( 'upload/groups/'. $group_id . '/group_logo_' . $group_id . '.png') ;
		} else {
			return static_url( 'img/default_group_logo.png' );
		}
	}
	
	
	
	
	
	/**
	 *	添加 "当前用户" 个人通知 Notice~ Add 
	 
	 
	 		Get Notice 在 Notice Controlller 内,ajax控制
	 */
	function add_notice( $user_id, $content, $link ) {
		$ci =& get_instance();
		$ci->load->model('notice_model');
		return $ci->notice_model->add_notice(  $user_id, $content, $link );
	}
	
	
	




	
	
	/**
	 *	话题~ helper函数
	 
	 		将topic的content转化成  402字内， 多了显示（显示更多）
	 */
	function kk_content_preview( $content, $limit= 402 ) {
	
		$return_arr = str_split( $content , $limit ); // 返回数组
		
		$return = strip_tags( $return_arr[0], '<a><img>' );
		
		// 如果返回内容很多，证明topic内容很多，添加省略号...
		if ( sizeof( $return_arr ) > 1 ) {
			$return .= '...';
		}
		
		return $return;
		
	}
	
	
	
	
	
	
	
	/**
	 *
	 *	Page View 页面浏览量~
	 *
	 */
	
	
	
	/**
	 *	为某群组提升一个“人气” （查看量）   一个session只能up一次人气！
	 		session... up_group.. 未设置，那么提升人气， 反之亦然
	 */
	function up_group_page_view( $group_id ) {
		$ci =& get_instance();
		
		if ( ! $ci->session->userdata( 'up_group_' . $group_id ) ) {
			// 提升人气！	
			$ci->load->model('group_model');
			
			// 设置session，告诉它已经up过人气了！
			$ci->session->set_userdata( 'up_group_' . $group_id, true );
			return $ci->group_model->up_group_page_view( $group_id );
			
		} else {
			return false;
		}
	}
	
	/**
	 *	为某用户提升一个“人气” （查看量）
	 		session...  up_user 未设置，那么，提升人气
	 */
	function up_user_page_view( $user_id ) {
		$ci =& get_instance();
		
		if ( ! $ci->session->userdata( 'up_user_' . $user_id ) ) {
			
			// 提升人气！ 未设置session参数!
			$ci->load->model('user_profiles_model');
			
			// 设置session~~ 每个user对应一个up_session, 只能提升一次
			$ci->session->set_userdata( 'up_user_' . $user_id , true );
			return $ci->user_profiles_model->up_user_page_view( $user_id );
			
		} else {
			return false;
		}	}
	
	
	
	
	