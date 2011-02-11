<?php
	// 全局应用的 javascript 变量
	$ci =& get_instance();
?>

$static_url = '<?=static_url();?>';


<?php
	//当前用户的头像存放目录
?>
$current_user_avatar_url = '<?=static_url("upload/avatars/") . get_current_user_id() . '/' ;?>';

<?php
	// Attach 图片的放置地方
?>
$attach_img_url = '<?=site_url("/static/upload/attach_img");?>';

<?php
	// 默认头像文件
?>
$default_user_avatar = '<?=static_url('img/default_avatar.jpg');?>';


<?php
	// 聊天chat自动刷新的时间
?>
$chat_refresh_time = 5000;

<?php	
		if ( is_logged_in() ):
		
			// JS - 当前登录用户ID
?>
			
	$js_current_user_id = <?=get_current_user_id();?>;
	
<?php
		endif;
?>