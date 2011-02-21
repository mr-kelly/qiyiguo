<!--

十分之荣幸你能查看页面的源代码

	也许，你懂技术～ 也许，你有激情～ 也许，你有想法～ 也许...
	不论怎样，也许，你可以联系我
	
	
	
	Mr Kelly
	
	电邮:  chepy.v@gmail.com
	果页:  http://qiyiguo.cc/u/mrkelly
	
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <meta name="description" content="［奇异果］是一个基于果群的社交网络，它帮助你发现与创造生活的每一刻。" />
    <meta name="keywords" content="同学,大学生,陈霈霖,Mrkelly,公司,小区,学校,社交网站" />
    
    <meta name="generator" content="BBEdit 9.5 / Komodo Edit 5" />
    
    <!-- no cache headers -->
<!-- 
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="no-cache"/>
    <meta http-equiv="Expires" content="-1"/>
    <meta http-equiv="Cache-Control" content="no-cache"/>
 -->
    <!-- end no cache headers -->
    
    <title><?= isset($page_title) ? $page_title : '奇异果';?></title>
    <link rel="shortcut icon" href="<?=static_url('img/favicon.gif');?>" type="image/gif" />


	<script>
    		// 通过省份获取城市的ajax地址
    		var $get_cities_url = '<?=site_url("user/ajax_get_cities/");?>';
	</script>
	
	<?php
		// JS 动态变量
	?>
	<script type="text/javascript" src="<?=site_url('import/js_vars');?>"></script>
	
    <?php
    	$this->load->view('import');
    ?>

</head>
<body>
	<noscript id="noscript">
		奇异果发现您的浏览器不支持JavaScript。这将严重影响你对网站浏览！
	</noscript>
	
	<div id="loading">
		<img src="<?=static_url('img/loading.gif');?>" />
		加载中...
	</div>
	
	<div id="loading_error">
		有加载出错
	</div>
       
       
    <?php $render = array(); $this->load->view('general/navigator', $render); ?>

		
		
		<div class="clearboth"></div>
		
		
    	<div id="nav_btn">
    		<a href="#" class="autohide_btn" onclick="return false;">导航菜单</a>
    	</div>
    	
    	
    </div>
    
    
    <div id="header">
        <div id="topbar">
            <!-- 

            <span class="topbar_corner"></span>
            <span class="topbar_corner"></span>
 -->
            
            <div id="topbar_container">
                <div id="logo">
                    <a href="<?=base_url();?>">
                        <img src="<?=static_url('img/logo.png');?>" height="35" />
                    </a>
                </div>
                
                <ul id="menu">
                
					<?php if ( is_logged_in() ): ?>
					<li class="menu_item <?=isset($current_user_home) ? $current_user_home : '' ;?>">
						<a href="<?=get_user_url( get_current_user_id() );?>">
							个人主页
						</a>
                        <div class="submenu">
                            <span class="submenu_corner"></span>
                            <span class="submenu_corner"></span>
							<span class="submenu_item">
								<a href="<?=site_url('home/start');?>">开始页</a>
							</span>
                        </div>
					</li>
					<?php else: // 未登录，显示首页 ?>

						
                    <li class="menu_item <?= isset($current_home) ? $current_home : '' ;?>">
                        <a href="<?=site_url('');?>">
                            首页
                        </a>
                        <!--
                        <div class="submenu">
                            <span class="submenu_corner"></span>
                            <span class="submenu_corner"></span>
							<span class="submenu_item">创建群组</span>
							<span class="submenu_item">创建群组</span>
                        </div>
                        -->
                    </li>
                    <?php endif; ?>
                     
                    <li class="menu_item <?= isset($current_group) ? $current_group : '' ;?>">
                    	<a href="<?=site_url('group');?>">
                    		果群
                    	</a>
                        <div class="submenu">
                            <span class="submenu_corner"></span>
                            <span class="submenu_corner"></span>
                            
							<span class="submenu_item">
								<a class="sexybox_iframe" href="<?=site_url('group/iframe_new_group');?>">创建群组</a>
							</span>
                        </div>
                    </li>
                    
                    <!--
                    <li class="menu_item <?= isset($current_person) ? $current_person : '' ;?>">
                    	<a href="#">
                    		找人
                    	</a>
                        <div class="submenu">
                            <span class="submenu_corner"></span>
                            <span class="submenu_corner"></span>
							<span class="submenu_item">创建群sd组</span>
							<span class="submenu_item">创建群组</span>
                        </div>
                    </li>
                    -->
                    <li class="menu_item <?= isset($current_event) ? $current_event : '' ;?>">
                    	<a href="<?=site_url('event');?>">
                    		活动
                    	</a>
                        <div class="submenu">
                            <span class="submenu_corner"></span>
                            <span class="submenu_corner"></span>
                            <span class="submenu_item">查看活动</span>
                            <span class="submenu_item">创建活动</span>

                        </div>
                    </li>
                    
                    <li class="menu_item <?= isset($current_friends) ? $current_friends : '' ;?>">
                    	<a href="<?=site_url('link');?>">
                    		连接
                    	</a>
                        <div class="submenu">
                            <span class="submenu_corner"></span>
                            <span class="submenu_corner"></span>
                            <span class="submenu_item">朋友</span>
                            <span class="submenu_item">果群</span>

                        </div>
                    </li>
                    
                </ul>
				
				<div class="search">
					<a class="sexybox_iframe" href="<?=site_url('search/iframe_search');?>">
						<img src="<?=static_url('img/search_pic.png');?>" />
					</a>
				</div>
				
				<!-- User Controller -->
				<div id="user_controller">
	
					<?php 
						// 判断登录状态
						if ($this->tank_auth->is_logged_in()) :
					?>
							<span class="submenu_item submenu_user">
								<a class="sexybox" href="<?=get_user_avatar_url($this->tank_auth->get_user_id(), $big=true);?>" title="<?=get_current_user_name();?>">
									<img width="18" src="<?=get_user_avatar_url();?>" />
								</a>
								
								<a href="<?=site_url('user/'. $this->tank_auth->get_user_id());?>">
									<?=get_current_user_name();?> (<?=get_current_user_id();?>)
								</a>
							</span>
						

							
							<span class="submenu_item">
								<a href="<?=site_url('user/setting');?>" class="icon icon_setting">
									个人设置
								</a>
							</span>
							<span class="submenu_item">
								<a id="logout_btn" href="<?=base_url();?>user/logout" class="icon icon_logout">登出</a>
								<script>
									var $user_logout_action = '<?=base_url();?>user/logout';
									var $user_home = '<?=base_url();?>';
								</script>
							</span>
							
							<span class="submenu_item">
								<a title="哗啦啦~ 将奇异果通过微博、QQ介绍给你朋友吧" href="#" class="tipsy_n icon icon_present">
									邀请朋友
								</a>
							</span>
					<?php
						else:
					?>
							<span class="submenu_item">
								<a id="login_btn" class="sexybox_iframe icon icon_login" href="<?=site_url('user/iframe_login');?>?redirect=<?=$this->input->get('redirect');?>">
									登录
								</a>
							</span>
							
							<span class="submenu_item">
								<a id="register_btn" class="sexybox_iframe icon icon_register" href="<?=site_url('user/iframe_register');?>" title="注册" href="<?=base_url();?>user/register">
									快速注册
								</a>
							</span>
							
							
					<?php
						endif;
					?>
					
				
				</div>
			
			
			
            </div>
            

        </div>
    </div>
    
    <!--Wrapper Start-->
    <div id="wrapper">
    	<!--Container Start-->
        <div id="container">
        	
        	<?php
        		$ci =& get_instance();
        		// Session Message, 有
        		if ( $ci->session_message->get() ):
        	?>
        			<script type="text/javascript">
        				kk_growl.session_message('<?=$ci->session_message->get();?>');
        			</script>
            
            <?php
            	else:
            		// 用于ajax信息提示
            ?>
            		<div class="session_message hidden"></div>
            		
            <?php
            	endif;
            ?>
            
            