<?php
include "../../../wp-config.php";

if(!class_exists('DoubanOAuth')){
	include dirname(__FILE__).'/doubanOAuth.php';
}

$to = new DoubanOAuth($douban_consumer_key, $douban_consumer_secret);
	
$tok = $to->getRequestToken();

update_option("douban_oauth_token_secret",$tok['oauth_token_secret']);

$request_link = $to->getAuthorizeURL($tok['oauth_token'])."&oauth_callback=".get_option('home');

header('Location:'.$request_link);
?>
