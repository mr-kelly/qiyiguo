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


	function kk_log($url, $message) {
		$ci =& get_instance();
		$ci->log_model->create_log($url, $message);
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
			return $CI->config->item('static_url') . $file;
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
			
			echo json_encode($arr);
			exit();
			
		}
	}
	
	
	// import JS
	if ( !function_exists('import_js')) {
		function import_js($href) {

			return sprintf('<script type="text/javascript" src="%s%s"></script>', static_url() , $href);
		}
	}
	
	// import CSS
	
	function import_css($href) {
		
		return sprintf('<link rel="stylesheet" type="text/css" media="all" href="%s%s" /> ', static_url(), $href);
	}
	
	
	/**
	 *  获得当前用户，以数组形式返回
	 *  可选参数$which, 返回用户的哪项资料
	 *  若未登陆，返回null
	 */
	if ( !function_exists('get_current_user_profile')) {
	
		function get_current_user_profile( $which = 'id' ) {
			$KK =& get_instance();
			$current_user_id = $KK->tank_auth->get_user_id();
			
			// 通过user_profiles Model 取得当前用户资料全数组
			$arr = $KK->user_profiles_model->get_profile($current_user_id);
			//return $arr[$which];
			return $arr[$which];
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
					return static_url(). 'upload/avatars/'. $user_id. '/' . $profile['Avatar']['avatar_thumb'];
				} elseif ( $big == true ) {
					// 返回大图
					return static_url(). 'upload/avatars/'. $user_id. '/' . $profile['Avatar']['avatar_file'];
				}
			
		} else {
			// 用户尚未设置头像，显示空头像...
			return static_url(). 'img/default_avatar.jpg';
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
			return static_url() . 'upload/groups/'. $group_id . '/group_logo_' . $group_id . '.png' ;
		} else {
			return static_url() . 'img/default_group_logo.png';
		}
	}
	
	
	
	
	
	/**
	 *	添加当前用户个人通知 Notice~ Add 
	 
	 
	 		Get Notice 在 Notice Controlller 内,ajax控制
	 */
	function add_notice( $content, $link ) {
		// TODO 
	}
	
	
	
	/**
	 *	KK输出视图函数，压缩了HTML
	 */
	function kk_show_view( $view, $data=array() ) {
		$ci =& get_instance();
		$ci->load->plugin('compress_html');
		//$ci->load->plugin('spaceless');
		
		$html = $ci->load->view($view, $data, true);

		// 输出压缩过的html
		echo compress_html( $html );
		//echo $html;
		
	}
	