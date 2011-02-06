<?php
/*
Plugin Name: Douban Connect
Author:  Denis
Author URI: http://fairyfish.net/
Plugin URI: http://fairyfish.net/2009/06/15/douban-connect/
Description: 能够使用豆瓣账号登陆你的 WordPress 博客，并且留言使用豆瓣的头像。
Version: 1.0
*/
$douban_consumer_key = '';
$douban_consumer_secret = '';

$dc_loaded = false;

add_action('init', 'dc_init');
add_filter("get_avatar", "dc_get_avatar",10,4);
add_action("wp_head", "dc_wp_head");
add_action('comment_form', 'douban_connect');

function dc_wp_head(){
    if(is_user_logged_in()) {
        if(isset($_GET['oauth_token'])){
			if(strpos($_SERVER['HTTP_REFERER'],"douban.com")!==false){
				echo '<script type="text/javascript">window.opener.dc_bookmark("");window.close();</script>';
			}
        }
	}
}
function dc_init(){
	if(!is_user_logged_in()) {
        if(isset($_GET['oauth_token'])){
			if(strpos($_SERVER['HTTP_REFERER'],"douban.com")!==false){
				dc_confirm();
			} 
        } 
    } 
}

function douban_connect(){
    global $dc_loaded;
    if($dc_loaded){
		return;
    }
    dc_show_douban_dc_button();
    $dc_loaded = true;
}

function dc_show_douban_dc_button($id='0'){
    global $dc_loaded;

    if($dc_loaded || is_user_logged_in()) {
        return;
    }
	
	$dc_url = WP_PLUGIN_URL.'/douban-connect';
	$dc_page = 'douban-start.php';

	$dc_btn_image = get_option('site_url').WP_PLUGIN_URL."/douban-connect/douban_button.gif";

	echo '<style id="twc_styles_text" type="text/css">
        .dc_button button{ 
        margin:0 7px 0 0; 
        background:none; 
        border:none; 
        cursor:pointer; 
        padding:5px 10px 6px 10px; /* Links */
		} 
        .dc_button button{ 
        width:auto; 
        overflow:visible; 
        padding:4px 10px 3px 7px; /* IE6 */ 
        } 
        .dc_button img{ 
        margin:0 3px -3px 0 !important; 
        padding:0; 
        border:none;
		}
    </style>';
	
    echo '<p id="dc_connect" class="dc_button"></p>';
	
    echo 
	'<script type="text/javascript">
    function dc_bookmark(){
       var url=location.href;
       var temp = url.split("#");
       url = temp[0];
       url += "#dcbutton";
       location.href = url;
       location.reload();
    }
    if(document.getElementById("dc_connect")){
        var button = document.createElement("button");
        button.id = "dc_button";
        button.setAttribute("class","dc_btn");
        button.onclick = function(){window.open("'.$dc_url.'/'.$dc_page.'", "dcWindow","width=800,height=800,left=150,top=100,scrollbar=no,resize=no");return false;};
        button.innerHTML = "<img src=\''.$dc_btn_image.'\' style=\'margin:0;\'>";
        document.getElementById("dc_connect").appendChild(button);
	}
	</script>';

    $dc_loaded = true;
}

function dc_get_avatar($avatar, $id_or_email='',$size='32') {
	global $comment;
	if(is_object($comment)) {
		$id_or_email = $comment->user_id;
	}
	if (is_object($id_or_email)){
		$id_or_email = $id_or_email->user_id;
	}
	if($dcid = get_usermeta($id_or_email, 'dcid')){
		$out = 'http://t.douban.com/icon/u'.$dcid.'-1.jpg';
		$avatar = "<img alt='' src='{$out}' class='avatar avatar-{$size}' height='{$size}' width='{$size}' />";
		return $avatar;
	}else {
		return $avatar;
	}
}

function dc_confirm(){
    global $douban_consumer_key, $douban_consumer_secret;
	
	if(!class_exists('DoubanOAuth')){
		include dirname(__FILE__).'/doubanOAuth.php';
	}
	$to = new DoubanOAuth($douban_consumer_key, $douban_consumer_secret, $_GET['oauth_token'],get_option('douban_oauth_token_secret'));
	
	$tok = $to->getAccessToken();

	$to = new DoubanOAuth($douban_consumer_key, $douban_consumer_secret, $tok['oauth_token'], $tok['oauth_token_secret']);
	
	$doubanInfo = $to->OAuthRequest('http://api.douban.com/people/%40me', array(), 'GET');
	if($doubanInfo == "no auth"){
		echo '<script type="text/javascript">window.close();</script>';
		return;
	}
	
	$doubanInfo = simplexml_load_string($doubanInfo);
	
	$doubanInfo_ns = $doubanInfo->children('http://www.douban.com/xmlns/');	

	$doubanInfo_id = str_replace("http://api.douban.com/people/","",$doubanInfo->id);
	$doubanInfo_url = "http://www.douban.com/people/".$doubanInfo_ns->uid;
		
	dc_Login($doubanInfo_id.'|'.$doubanInfo_ns->uid.'|'.$doubanInfo->title.'|'.$doubanInfo->url.'|'.$tok['oauth_token'] .'|'.$tok['oauth_token_secret']); 
}

function dc_Login($pdvUserinfo) {
	$userinfo = explode('|',$pdvUserinfo);
	if(count($userinfo) < 6) {
		wp_die("An error occurred while trying to contact Twit Connect.");
	}

	$userdata = array(
		'user_pass' => wp_generate_password(),
		'user_login' => $userinfo[1],
		'display_name' => $userinfo[2],
		'user_url' => $userinfo[3],
		'user_email' => $userinfo[1].'@douban.com'
	);

	if(!function_exists('wp_insert_user')){
		include_once( ABSPATH . WPINC . '/registration.php' );
	} 
  
	$wpuid = get_user_by_login($userinfo[1]);
	
	if(!$wpuid){
		if($userinfo[0]){
			$wpuid = wp_insert_user($userdata);
		
			if($wpuid){
				update_usermeta($wpuid, 'dcid', $userinfo[0]);
				$dc_array = array (
					"oauth_access_token" => $userinfo[4],
					"oauth_access_token_secret" => $userinfo[5],
				);
				update_usermeta($wpuid, 'dcdata', $dc_array);
			}
		}
	} else {
		update_usermeta($wpuid, 'dcid', $userinfo[0]);
		$dc_array = array (
			"oauth_access_token" => $userinfo[4],
			"oauth_access_token_secret" => $userinfo[5],
		);
		update_usermeta($wpuid, 'dcdata', $dc_array);
	}
  
	if($wpuid) {
		wp_set_auth_cookie($wpuid, true, false);
		wp_set_current_user($wpuid);
	}
}

function dc_doubanuser_to_wpuser($dcid) {
  return get_user_by_meta('dcid', $dcid);
}

function get_user_by_meta($meta_key, $meta_value) {
  global $wpdb;
  $sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '%s' AND meta_value = '%s'";
  return $wpdb->get_var($wpdb->prepare($sql, $meta_key, $meta_value));
}

function get_user_by_login($user_login) {
  global $wpdb;
  $sql = "SELECT ID FROM $wpdb->users WHERE user_login = '%s'";
  return $wpdb->get_var($wpdb->prepare($sql, $user_login));
}
?>