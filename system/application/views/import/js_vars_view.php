<?php
	// 全局应用的 javascript 变量
?>

<?php	
		if ( is_logged_in() ):
		
			// JS - 当前登录用户ID
?>
			
	$js_current_user_id = <?=get_current_user_id();?>;
	
<?php
		endif;
?>