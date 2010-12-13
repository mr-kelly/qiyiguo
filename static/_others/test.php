<?php
	require_once('./weibo.class.php');
	
	$weibo = new weibo('3605840884');
	
	$weibo->setUser('chepy6', '626626');
	
	$r = $weibo->friends_timeline();
	
	var_dump( $r);