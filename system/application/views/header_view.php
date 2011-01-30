<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="［奇异果］让大学生们轻松买卖二手教科书，结识学术上的朋友。" />
    <meta name="keywords" content="教科书,二手书,同学,大学生" />
    
    <!-- no cache headers -->
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="no-cache"/>
    <meta http-equiv="Expires" content="-1"/>
    <meta http-equiv="Cache-Control" content="no-cache"/>
    <!-- end no cache headers -->
    
    <title><?= isset($page_title) ? $page_title : '奇异果';?></title>
    <link rel="shortcut icon" href="<?=static_url();?>img/favicon.gif" type="image/gif" />


	<script>
    		// 通过省份获取城市的ajax地址
    		var $get_cities_url = '<?=site_url("user/ajax_get_cities/");?>';
	</script>

    <?php
    	$this->load->view('import');
    ?>
    <script>
    	$(function(){
    		
    		
    		$('a.lightbox').lightBox({
    			'imageLoading': '<?=static_url();?>js/jquery-lightbox/images/lightbox-ico-loading.gif',
    			'imageBtnClose':'<?=static_url();?>js/jquery-lightbox/images/lightbox-btn-close.gif',
				'imageBtnPrev': '<?=static_url();?>js/jquery-lightbox/images/lightbox-btn-prev.gif',
				'imageBtnNext': '<?=static_url();?>js/jquery-lightbox/images/lightbox-btn-next.gif'
    		});
    	});
    	

    </script>

</head>
<body>

	
	<div id="loading">
		<img src="<?=static_url();?>img/loading.gif" />
		加载中...
	</div>
	
	<div id="loading_error">
		有加载出错
	</div>
       
       
       
    <div id="navigator">
    	<div class="nav_content">
	    	<ul>
	    		<li>
	    			<a href="#">
	    				我的页面
	    			</a>
	    		</li>
	    		<li>
	    			<a href="#">
	    				我的群组
	    			</a>
	    		</li>
	    	</ul>
    	</div>
		
		
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
                        <img src="<?=static_url();?>img/logo.png" height="35" />
                    </a>
                </div>
                
                <ul id="menu">
                    <li class="menu_item <?= isset($current_home) ? $current_home : '' ;?>">
                        <a href="<?=site_url('');?>">
                            首页
                        </a>
                        <div class="submenu">
                            <span class="submenu_corner"></span>
                            <span class="submenu_corner"></span>
							<span class="submenu_item">创建群组</span>
							<span class="submenu_item">创建群组</span>
                        </div>
                    </li>
                     
                    <li class="menu_item <?= isset($current_group) ? $current_group : '' ;?>">
                    	<a href="<?=site_url('group');?>">
                    		群组
                    	</a>
                        <div class="submenu">
                            <span class="submenu_corner"></span>
                            <span class="submenu_corner"></span>
                            
							<span class="submenu_item">
								<a href="<?=site_url('group/new_group');?>">创建群组</a>
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
                    
                    <li class="menu_item">
                    	<a href="#">
                    		活动
                    	</a>
                        <div class="submenu">
                            <span class="submenu_corner"></span>
                            <span class="submenu_corner"></span>
                            <span class="submenu_item">创建群组</span>
                            <span class="submenu_item">创建群组</span>

                        </div>
                    </li>
                    -->

                    
                </ul>

				<!-- User Controller -->
				<div style="text-align:right;width:100%;float:right;margin:8px 0 0 0;">
	
					<?php 
						// 判断登录状态
						if ($this->tank_auth->is_logged_in()) :
					?>
						<a class="sexybox" href="<?=get_user_avatar_url($this->tank_auth->get_user_id(), $big=true);?>">
							<img width="18" src="<?=get_user_avatar_url();?>" />
						</a>
						
						<a href="<?=site_url('user/'. $this->tank_auth->get_user_id());?>"><?=get_current_user_name();?></a>
						
							<span class="submenu_item">
								<a href="<?=site_url('user/setting');?>">[设置]</a>
							</span>
							<span class="submenu_item">
								<a id="logout_btn" href="<?=base_url();?>user/logout">[登出]</a>
								<script>
									var $user_logout_action = '<?=base_url();?>user/logout';
									var $user_home = '<?=base_url();?>';
								</script>
							</span>
					<?php
						else:
					?>
							<span class="submenu_item">
								<a id="login_btn" class="sexybox_iframe" href="<?=site_url('user/iframe_login');?>?redirect=<?=$this->input->get('redirect');?>">[登录]</a>
							</span>
							
							<span class="submenu_item">
								<a id="register_btn" class="sexybox_iframe" href="<?=site_url('user/iframe_register');?>" title="注册" href="<?=base_url();?>user/register">[注册]</a>
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
					<div class="session_message">
						<?=$ci->session_message->get();?>
					</div>
            
            <?php
            	else:
            		// 用于ajax信息提示
            ?>
            		<div class="session_message hidden"></div>
            		
            <?php
            	endif;
            ?>
            
            
