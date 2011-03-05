<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>奇异果General header</title>
	
	
	
	<?php
		// JS 动态变量
	?>
	<script type="text/javascript" src="<?=site_url('import/js_vars');?>"></script>
	
	<?=import_js('js/lib/lib.js');?>
	<?=import_js('js/global.js');?>
	
	<?php
		$this->load->view('import');
	?>
</head>
<body>
	<div id="loading" class="hidden">
		<img src="<?=static_url('img/loading.gif');?>" />
		
	</div>
