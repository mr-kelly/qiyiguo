<!--

十分之荣幸你能查看页面的源代码

	你是否懂技术？
	你是否有改变生活的创意？
	你是否有改变世界的理想？

	
	也许，你应该活出你的未来。
	
	
	
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
    <meta name="description" content="奇异果 - <?=isset( $page_description ) ? $page_description : '「奇异果」是一个世界上第一个群组网络，它帮助你和朋友们发现与创造生活的每一刻。你可以这这里发现、创建你的住宅小区、校园社团、朋友组织各种群组。';?>" />
    <meta name="keywords" content="同学,大学生,陈霈霖,Mrkelly,公司,小区,学校,社交网站,社团" />
    <meta name="google-site-verification" content="K8Ch8aWFVaAp6Ek_ru8RGntVWxjqxCkYV16ZGChFF84" />
    <meta name="generator" content="BBEdit 9.5" />
    
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
    		
	</script>
	
					   <script>
						   //var $user_logout_action = '<?=base_url();?>user/logout?redirect=';
						   //var $user_home = '<?=base_url();?>';
					   </script>
					   
	
					   
	<?php
		// JS 动态变量
	?>
	<script type="text/javascript" src="<?=site_url('import/js_vars?ajax=' . rand() );?>"></script>
	
    <?php
    	$render['form_key_token'] = !empty( $form_key_token ) ? $form_key_token : '';
    	$this->load->view('import', $render );
    ?>


	
</head>
<body>
	<noscript id="noscript">
		奇异果发现您的浏览器不支持JavaScript。这将严重影响你对网站浏览！
	</noscript>
	
	<div id="sound">
	
	</div>
	
	<div id="loading">
		<img src="<?=static_url('img/loading.gif');?>" />
		<?= !isset( $loading_text ) ? '加载中,请稍候...' : $loading_text; ?>
	</div>
	
	<div id="loading_error">
		有加载出错
	</div>
	

    <?php if ( is_logged_in() ) : // 登录才显示导航菜单?>
    <?php $render = array(); $this->load->view('general/navigator', $render); ?>
	<?php endif; ?>
		
		

    	
    	
    </div>
    
    <?php if ( !isset( $hide_header ) ) : ?>
    <div id="kk_header">
        <div id="kk_topbar">
            <!-- 

            <span class="topbar_corner"></span>
            <span class="topbar_corner"></span>
 -->
            
            <div id="kk_topbar_container">
                <div id="logo" class="tipsy_nw" title="奇异果帮助你和你的朋友们发现和创造生活。">
                    <a href="<?=site_url('/');?>">
                        <img src="<?=static_url('img/logo.gif');?>" height="35" />
                    </a>
                </div>
                
                <ul id="kk_menu">
                
					<?php if ( is_logged_in() ): ?>
					<li class="menu_item <?=isset($current_user_home) ? 'current_menu' : '' ;?>">
						<a href="<?=site_url('home/start');?>">
							首页
						</a>
                        <div class="submenu">
                            <span class="submenu_corner_left"></span>
                            <span class="submenu_corner_right"></span>
							<span class="submenu_item">
								<a href="<?=site_url('home/start');?>">开始页</a>
							</span>
							<span class="submenu_item">
								<a href="<?=get_user_url( get_current_user_id() );?>">个人主页</a>
							</span>
                        </div>
					</li>
					<?php else: // 未登录，显示首页 ?>

						
                    <li class="menu_item <?= isset($current_home) ? 'current_menu' : '' ;?>">
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
                     
                    <li class="menu_item <?= isset($current_group) ? 'current_menu' : '' ;?>">
                    	<a href="<?=site_url('group');?>">
                    		果群
                    	</a>
                        <div class="submenu">
                            <span class="submenu_corner_left"></span>
                            <span class="submenu_corner_right"></span>
                            
							<span class="submenu_item">
								<a href="<?=site_url('user/my_groups');?>">我的群组</a>
							</span>
							
							<span class="submenu_item">
								<?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false ): ?>
								<a id="create_group_btn" class="" href="<?=site_url('group/iframe_new_group');?>">创建群组</a>
								<?php else: ?>
								<a id="create_group_btn" class="sexybox_iframe" href="<?=site_url('group/iframe_new_group');?>">创建群组</a>
								<?php endif;?>
							</span>
							
                        </div>
                    </li>
                    
                    <li class="menu_item <?= isset($current_topic) ? 'current_menu' : '' ;?>">
                    	<a href="<?=site_url('topic');?>">
                    		话题
                    	</a>
                        <div class="submenu">
                            <span class="submenu_corner_left"></span>
                            <span class="submenu_corner_right"></span>
                            
							<span class="submenu_item">
								<a href="<?=site_url('topic/my_topics');?>">我的话题</a>
							</span>

							<span class="submenu_item">
								<a href="<?=site_url('topic/add_topic');?>">创建话题</a>
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
                    <li class="menu_item <?= isset($current_event) ? 'current_menu' : '' ;?>">
                    	<a href="<?=site_url('event');?>">
                    		活动
                    	</a>
                        <div class="submenu">
                            <span class="submenu_corner_left"></span>
                            <span class="submenu_corner_right"></span>
<!-- 
                            <span class="submenu_item">
                            	<a href="<?=site_url('event');?>">
                            		我的
                            	</a>
                            </span>
 -->
                             <span class="submenu_item">
                            	<a href="<?=site_url('event/my_events');?>">
                            		我的活动
                            	</a>
                            </span>
                            <span class="submenu_item">
                            	<a href="<?=site_url('event/add_event');?>">
                            		创建活动
                            	</a>
                            </span>


                        </div>
                    </li>
                    
                    <li class="menu_item <?= isset($current_explore) ? 'current_menu' : '' ;?>">
                    	<a href="<?=site_url('explore');?>">
                    		发现
                    	</a>
                    </li>
                    
                    
                    <!--
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
                    -->
                    
                </ul>
				
				<div class="search">
					<form onsubmit="return search_submit_check( this )" class="search_form" target="_blank" method="get" action="<?=site_url('search');?>">
					
						<input class="search_input" type="text" name="q" />
						
						<button title="搜索" class="tipsy_n search_btn" type="submit"><!--搜索--></button>
						
					</form>
					
					<script>
				//		$(function(){
							
			//				$('.search_input').input_tips( $search_input_tips_text );
// 							
// 							$('.search_form').submit(function(){
// 
// 								
// 							});
							
							
					//	});
					

					</script>
					<!-- 

					<a class="sexybox_iframe" href="<?=site_url('search/iframe_search');?>">
						<img src="<?=static_url('img/search_pic.png');?>" />
					</a>
 -->
				</div>
				
				<?php if ( is_logged_in() ) :?>
				<div id="user_display">
					<span class="submenu_item submenu_user">
						
						<a class="sexybox" href="<?=get_user_avatar_url($this->tank_auth->get_user_id(), $big=true);?>" title="<?=get_current_user_name();?>">
							<img width="18" src="<?=get_user_avatar_url();?>" />
						</a>
						
						<a href="<?= get_user_url( get_current_user_id() );?>">
							<?php
								$user_profile = get_current_user_profile();
							?>
							<?=get_current_user_name();?> (<?=get_current_user_id();?>)
							: <?= kk_content_preview( $user_profile['mood'], 51 ); ?>
						</a>
					</span>
				
				
				</div>
				<?php endif; ?>
				
				<!-- User Controller -->
				<div id="user_controller">
					
					<?php 
						if ( is_logged_in() ) :
							$ci =& get_instance();
							$ci->load->model('notice_model');
							if ( $ci->notice_model->get_notices_count( get_current_user_id() ) ) :
					?>
					
						<span class="submenu_item">
							<a href="<?=site_url('user/clear_notices');?>" class="icon icon_clear tipsy_n" title="提醒太多很烦？点击这里清空所有提醒">
								清空提醒
							</a>
						</span>
						
					<?php
							endif;
						endif;
					?>
					
					
					<span class="submenu_item">
						<a target="_blank" style="*width:90px;" title="还没搞懂奇异果干啥？去看看就对了" href="<?=site_url('home/demo');?>" class="tipsy_n icon icon_question">
							奇异果怎么用
						</a>
					</span>
					
					<?php if ( isset( $_SERVER['HTTP_REFERER'] ) ) : ?>
					<span class="submenu_item">
						<a href="<?=$_SERVER['HTTP_REFERER'];?>" class="icon icon_back">
							返回上页
						</a>
					</span>
					<?php endif; ?>
					
					<?php 
						// 判断登录状态
						if ($this->tank_auth->is_logged_in()) :
					?>


							
							<span class="submenu_item">
								<a href="<?=site_url('user/setting');?>" class="icon icon_setting">
									个人设置
								</a>
							</span>
							<span class="submenu_item">
								<a id="logout_btn" href="<?=base_url();?>user/logout?redirect=" class="icon icon_logout">
									退出
								</a>

							</span>
							
							<span class="submenu_item">
								<a title="哗啦啦~ 将奇异果通过微博、QQ介绍给你朋友吧" href="<?=site_url('invite');?>" class="tipsy_n icon icon_present">
									邀请朋友
								</a>
							</span>
							

							

								
					<?php
						else:
					?>
							<span class="submenu_item">
								<?php 
									// Redirect-> 如果设置GET redirect,那么就display redirect~  没有，将redirect设为当前页面 
									// 这样，可以令跳转的登录窗口生效
									//IE 6到指定的登录页
									if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false ):
								?>
								<a id="" class="icon icon_login" href="<?=site_url('user/iframe_login' );?>?redirect=<?= isset($_GET['redirect']) ? $this->input->get('redirect') : uri_string();?>"> 
								<?php
									else:
								?>
								<a id="login_btn" class="sexybox_iframe icon icon_login" href="<?=site_url('user/iframe_login' );?>?redirect=<?= isset($_GET['redirect']) ? $this->input->get('redirect') : uri_string();?>"> 
								<?php endif; ?>
									登录
								</a>
							</span>
							
							<span class="submenu_item">
								<?php 
									if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false ):
								?>
								<a id="" class="icon icon_register" href="<?=site_url('user/iframe_register');?>?redirect=<?= isset($_GET['redirect']) ? $this->input->get('redirect') : uri_string();?>" title="注册">
									快速注册
								</a>
								<?php else: ?>
								<a id="register_btn" class="sexybox_iframe icon icon_register" href="<?=site_url('user/iframe_register');?>?redirect=<?= isset($_GET['redirect']) ? $this->input->get('redirect') : uri_string();?>" title="注册">
									快速注册
								</a>
								<?php endif; ?>
							</span>
							
							
					<?php
						endif;
					?>
					
				
				</div>
			
			
			
            </div>
            

        </div>
    </div>
    <?php endif; ?>
    
    
    <!--Wrapper Start-->
    <div id="kk_wrapper">
    	<!--Container Start-->
        <div id="kk_container">
        	
        	<?php
        		$ci =& get_instance();
        		// Session Message, 有
        		$session_message = $ci->session_message->get();
        		
        		if ( $session_message ):
        	?>
        			<script type="text/javascript">
        				kk_growl.session_message('<?=$session_message;?>');
        			</script>
            
            <?php
            	else:
            		// 用于ajax信息提示
            ?>
            		<!--<div class="session_message hidden"></div>-->
<!-- 
        			<script type="text/javascript">
        				kk_growl.session_message('<?=$session_message;?>');
        			</script>
 -->
            <?php
            	endif;
            ?>
            
            
