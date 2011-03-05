<?php
	// 全局应用的 javascript 变量
	$ci =& get_instance();
?>
var $static_url = '<?=static_url();?>';

<?php // ajax获取城市 ?>
var $get_cities_url = '<?=site_url("user/ajax_get_cities/");?>';

<?php
	// Attach 图片的放置地方
?>
var $attach_img_url = '<?=site_url("/static/upload/attach_img");?>';

<?php
	// 默认头像文件
?>
var $default_user_avatar = '<?=static_url("img/default_avatar.jpg");?>';


<?php
	// 聊天chat自动刷新的时间
?>
var $chat_refresh_time = 5000;

<?php	
		if ( is_logged_in() ):
		
			// JS - 当前登录用户ID
?>
			
var $js_current_user_id = '<?=get_current_user_id();?>';



<?php
	//当前用户的头像存放目录
?>
var $current_user_avatar_url = '<?=static_url("upload/avatars/") . get_current_user_id() . '/' ;?>';


<?php
		endif;
?>




<?php
	
?>

var $topic_upload_pic_url = '<?=site_url("topic/ajax_topic_upload_pic");?>';