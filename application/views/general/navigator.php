    <div id="navigator">
    
    	<?php // navigator是close时， 关闭按钮不显示 ?>
    	<a href="<?=site_url('user/ajax_user_option/navigator/close');?>" id="nav_close" class="<?= get_user_option('navigator') == 'close' ? 'hidden' : '' ;?>"></a>
    	
    	<?php // navigator是close时， 主题内容不显示 ?>
    	<div class="nav_content <?= get_user_option('navigator') != 'close' ? '' : 'hidden' ;?>">
    		<div class="nav_content_top">
    			<div class="nav_content_bottom">
    				<?php
    					//echo get_user_option( 'navigator' );
    				?>
					<ul>
						<li class="nav_h">个人</li>
						

						<li>
							<a href="<?=site_url('home/start');?>">
								<span class="icon icon_start"></span>
								开始页
							</a>
						</li>
						
						<li>
							<a href="<?=get_user_url( get_current_user_id() );?>">
								<span class="icon icon_person"></span>
								个人主页
							</a>
						</li>
						<li>
							<a href="<?=site_url('user/follows/' . get_current_user_id() );?>">
								<span class="icon icon_friends"></span>
								收藏朋友
							</a>
						</li>
						<li>
							<a href="<?=site_url('user/setting');?>">
								<span class="icon icon_setting"></span>
								个人设置
							</a>
						</li>
						
						
						<li class="nav_h">果群</li>
						
						<?php
							// 获取管理的群组~
							if ( is_logged_in() ) :
								$ci =& get_instance();
								$ci->load->model('group_model');
								$current_user_admin_groups = $ci->group_model->get_user_groups( get_current_user_id(), null ) ;
								
								if ( !empty( $current_user_admin_groups ) ) :
									foreach( $current_user_admin_groups as $group ):
						?>
							<li>
								<a class="tipsy_w" title="<?=$group['name'];?>" href="<?=get_group_url( $group['id'] );?>">
									<span class="group_logo">
										<img width="16" height="16" src="<?=get_group_logo_url( $group['id'] );?>" />
									</span>
									<?=$group['name'];?>
								</a>
							</li>
						<?php
									endforeach;
								endif;
							endif;
						?>
						<li>
							<a href="<?=site_url('user/my_groups');?>">
								<span class="icon icon_joined_group"></span>
								我的果群
							</a>
						</li>
						<li>
							<a href="<?=site_url('topic/my_topics');?>">
								<span class="icon icon_topic"></span>
								我的话题
							</a>
						</li>
						
						<li>
							<a href="<?=site_url('event/my_events');?>">
								<span class="icon icon_event"></span>
								我的活动
							</a>
						</li>
						
						<li>
							<a href="<?=site_url('group/');?>">
								<span class="icon icon_group"></span>
								找果群
							</a>
						</li>
					</ul>
				</div>
			</div>
    	</div>
    	
		<div class="clearboth"></div>
		
		

    	<?php // navigator option 是close时， “导航菜单” 按钮显示 ?>
    	<a href="<?=site_url('user/ajax_user_option/navigator/show');?>" id="nav_btn" class="autohide_btn <?= get_user_option('navigator') == 'close' ? '' : 'hidden' ;?>" onclick="return false;">导航菜单</a>
