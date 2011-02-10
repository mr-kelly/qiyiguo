<?php
	// 全局应用的 javascript 变量
?>

<?php
	// Attach 图片的放置地方
?>
$attach_img_url = '<?=site_url("/static/upload/attach_img");?>';


<?php	
		if ( is_logged_in() ):
		
			// JS - 当前登录用户ID
?>
			
	$js_current_user_id = <?=get_current_user_id();?>;
	
<?php
		endif;
?>