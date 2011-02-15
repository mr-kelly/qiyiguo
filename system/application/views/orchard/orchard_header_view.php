<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>奇异果 果园</title>
	<?=import_css('css/base.css');?>
	<?=import_css('css/app/orchard/style.css');?>
	
</head>
<body>

	<div id="header">
		<div id="logo">
			<a href="<?=site_url('orchard');?>">
				<img height="35" src="<?=static_url('img/logo.png');?>" />
			</a>
		</div>
		<ul id="menu">
			<li>
				<a href="<?=site_url('orchard/user');?>">
					用户
					<ul class="submenu">
						<li>
							<a href="<?=site_url('orchard/user/create_user');?>">创建用户</a>
						</li>
						
						<div class="clearboth"></div>
						
					</ul>
				</a>
				

			</li>
			<li>
				<a href="<?=site_url('orchard/group');?>">果群</a>
			</li>
		</ul>
	</div>

	
	<div id="container">
	
	