<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>奇异果</title>
	<meta name="generator" content="BBEdit 9.6">
	<?=import_css('css/html.css');?>
	<?=import_css('css/style.css');?>
</head>
<body>

<div id="content" style="text-align:left;">
<?php
	if ( !is_logged_in() ) :
?>
	<a href="http://qiyiguo.cc" target="_blank">请先登录</a>
<?php
	else:
?>


<h2>我的群</h2>

<?php
		$ci =& get_instance();
		$ci->load->model('group_model');
		$user_groups = $ci->group_model->get_user_groups( get_current_user_id(), null );
		
		$ci->load->view('group/general_groups_show', array(
			'groups' => $user_groups,
			'_blank' => true,
		));
?>
<?php
	endif;
?>
</div>



</body>
</html>
