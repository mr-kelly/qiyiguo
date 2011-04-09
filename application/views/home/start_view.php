<?php
	$this->load->view('header_view');
	
	
?>
	<?=import_css('css/app/home/start.css');?>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				
				<h1>开始页</h1>
				
				
				
				<?php
					// 内涵指数小于60， 提示去提升内涵指数吧
					if ( $user_inner_index < 40 ) :
				?>
				
				<div class="align_center grey">
					<div>
						这里是开始页面。你可以在这里看看有没有你熟悉的群组。 
					</div>
					
					<div>
						如果没有，你可以创建一个班群、社团群或者宿舍群，让你的伙伴们加入吧。
					</div>
					<br />
					<br />
				</div>
				
				<div class="tipsy_s" title="内涵指数是系统根据你所填写的个人资料给予你的一个内涵评分，将会根据你个人的内涵信息进行评分。">
					<div id="inner_index_bar">
						<?php foreach ( range(1, $user_inner_index) as $num )  : ?>
						<div class="inner_index_line"></div>
						<?php endforeach; ?>
					</div>
					
					<div class="align_center">
						内涵指数: 
						<span class="big red">
							<?=$user_inner_index;?>%
						</span>
						...
						<a href="<?=site_url( 'user/setting' );?>">
							&gt;去提升内涵指数
						</a>
					</div>
				</div>
				<?php endif; ?>
				
				<?php if ( !empty( $random_groups) ) : ?>
				<div class="clearboth">
					<h2>你知道这些组织吗?</h2>
					<?php
						$this->load->view('group/general_groups_show', array(
							'groups' => $random_groups,
						));
					?>
				</div>
				<?php endif; ?>


					
					
				<div class="clearboth"></div>
				
				
				
				
				<div id="start_show">
					
					<div class="start_block">
						<h2 class="tipsy_s" title="你所加入的群组的最新话题">群话题</h2>
						
						<div class="grey">
								&gt;这些是你加入的群的最新话题
						</div>
						
						<?php
							$this->load->view('topic/general_topics_showlist', array(
								'topics' => $user_groups_topics,
							));
						?>
						
						<?php
							if ( empty( $user_groups_topics ) ):
						?>
							<div class="grey align_center">
								<b>还没加入任何群...</b>
								<a href="<?=site_url('group');?>">
									->去看看
								</a>

							</div>
						<?php
							endif;
						?>
						
						
						
						<div class="clearboth"></div>
						
						<?php if ( !empty( $user_groups_topics ) ) : ?>
						<div class="align_right">
							<a href="<?=site_url('topic/my_topics');?>">
								&gt;更多群话题...
							</a>
						</div>
						<?php endif; ?>
						
					</div>
					
					<div class="start_block">
						<h2 class="tipsy_e" title="你所加入的群的最新活动/任务">群活动</h2>
						
						<div class="grey">
								&gt;这些是你加入的群的最新活动
						</div>
						
						<?php
							$this->load->view('event/general_events_showlist', array(
								'events' => $user_groups_events,
								//'show_group_name' => true,
							));
						?>
						
						
						
						<div class="clearboth"></div>
						
						<?php if ( !empty( $user_groups_events ) ) : ?>
						<div class="align_right">
							<a href="<?=site_url('event/my_events');?>">
								&gt;更多群活动...
							</a>
						</div>
						<?php endif; ?>
						
					</div>
					
					<div class="clearboth"></div>
					
				</div>
				
				
				<div class="clearboth"></div>
				
				
				<?php if ( !empty( $user_admin_groups ) ) : ?>
				
				<div class="clearboth">
					<h2 title="在这些群里，你是管理员" class="tipsy_e">你管理的群 (<?=$user_admin_groups_count;?>)</h2>
					<?php
						$this->load->view('group/general_groups_show', array(
							'groups' => $user_admin_groups,
						));
					?>
				</div><!--END 管理群-->
				
				<?php
					else:
				?>
				
					<div class="grey align_center clearboth">
						你还没有管理任何群...你可以
						<a class="sexybox_iframe" href="<?=site_url( 'group/iframe_new_group' );?>">
							&gt;创建一个群
						</a>
					</div>
					
					
				<?php
					endif;
				?>
				
			</div>
			
		</div>
	</div>
	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				

				
				<div class="sidebar_widget">
					<h2>个人资料</h2>
					<?php
						$this->load->view('sidebar/sidebar_user_profile', array(
							'user' => get_current_user_profile(),
						));
					?>
				</div>
				
				<div class="sidebar_widget align_center">
					<form onsubmit="return mood_form();" class="mood_form" method="post" action="<?=site_url('user/ajax_add_mood');?>">
						<input class="mood_text input_text" name="mood_text" value="今天心情怎样？" />
						<button type="submit" class="kk_btn">
							改变心情
						</button>
					</form>
				</div>
				
				
<!-- 
				<div class="sidebar_widget">
					<h2>快速进入</h2>
					<a class="btn" href="#"><span><span>为社团、班级创建群组</span></span></a>
				</div>
				
				<div class="sidebar_widget">
					<h2>你可能感兴趣...</h2>
					
				</div>
				
				<div class="sidebar_widget">
					<h2>你可能认识...</h2>
					
				</div>
 -->
				
				
				
				
				<div class="sidebar_widget">
					<h2>我的群 (<?=$user_groups_count;?>)</h2>
					<ul class="sidebar_menu sidebar_links">
					<?php
						if ( !empty( $user_groups ) ) :
						foreach( $user_groups as $group ) :
					?>
						<li class="tipsy_e" title="<?=$group['name'];?> <?=$group['intro'];?>">
							<span>
								<a href="<?= get_group_url( $group['id'] );?>">
									<span class="hover"></span>
									<img class="group_logo" width="18" src="<?= get_group_logo_url( $group['id'] );?>" />
									
									<?= kk_content_preview( $group['name'], 30 );?>
								</a>
							</span>
						</li>
					<?php
						endforeach;
						else:
					?>
						<div class="align_center grey">
							<b>还没加入任何群</b>
							<a href="<?=site_url('group');?>">
								->去看看
							</a>
						</div>
					<?php
						endif;
					?>
					</ul>
					
					<div class="clearboth"></div>
				</div>
				
				<?php
					$this->load->view('sidebar/sidebar_client');
				?>

				
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>