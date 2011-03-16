<?php
	$ci =& get_instance();
	$ci->load->view('header_view', array(
		'page_title' => '奇异果表示找不到页面... (404)',
	));
?>



<style type="text/css">
/*

body {
background-color:	#fff;
margin:				40px;
font-family:		Lucida Grande, Verdana, Sans-serif;
font-size:			12px;
color:				#000;
}

#content  {
border:				#999 1px solid;
background-color:	#fff;
padding:			20px 20px 12px 20px;
}

h1 {
font-weight:		normal;
font-size:			14px;
color:				#990000;
margin: 			0 0 4px 0;
}
*/
</style>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>找不到该页面 ( 404 ) </h1>
				<div>
					奇异果找不到这个页面，这应该是我们的错。
				</div>
			<!--
				<h1><?php echo $heading; ?></h1>
				<?php echo $message; ?>
			-->
			</div>
		</div>
	</div>
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php
					$ci->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>


<?php $ci->load->view('footer_view'); ?>