<?php
	$this->load->view('header_view');
	
	
?>
	<?=import_css('css/app/home/start.css');?>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				
				<?php
					// 内涵指数小于60， 提示去提升内涵指数吧
					if ( $user_inner_index < 60 ) :
				?>
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
				
				<?php if ( !empty( $user_admin_groups ) ) : ?>
				
				<div class="clearboth">
					<h2>你管理的群 (<?=$user_admin_groups_count;?>)</h2>
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
						没有管理的群...
						<a class="sexybox_iframe" href="<?=site_url( 'group/iframe_new_group' );?>">
							&gt;创建一个
						</a>
					</div>
					
					
				<?php
					endif;
				?>

					
					
				<div class="clearboth"></div>
				
				
				
				
				<div id="start_show">
					
					<div class="start_block">
						<h2>我的群话题</h2>
						<ul class="topics_show">
						<?php
							if ( !empty( $user_groups_topics ) ) : 
							foreach( $user_groups_topics as $topic ) : 
								$topic_group = kk_get_group( $topic['model_id'] );
								$topic_user = kk_get_user( $topic['user_id'] );
						?>
							<li>
								<div class="float_right">
									<span class="tipsy_s" title="组织者:<?= $topic_user['name'];?>">
										<a href="<?= get_user_url( $topic_user['id'] );?>">
											<img width="24" src="<?= get_user_avatar_url( $topic_user['id'] );?>" />
										</a>
									</span>
									
									<span class="tipsy_s" title="来自<?= $topic_group['name'];?>">
										<a href="<?= get_group_url( $topic_group['id'] );?>">
											<img width="24" src="<?= get_group_logo_url( $topic_group['id'] );?>" />
										</a>
									</span>

								</div>
								
								<a href="<?=site_url('topic/' . $topic['id'] );?>">
									<?php if ( $topic['title'] != '' ) : ?>
										<?= $topic['title'];?>
									<?php else: ?>
										<?= kk_content_preview( $topic['content'], 42 );?>
									<?php endif; ?>
								</a>
								
							</li>
						<?php
							endforeach;
							else:
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
						</ul>
						
						<div class="clearboth"></div>
						
						<?php if ( !empty( $user_groups_topics ) ) : ?>
						<div class="align_right">
							<a href="<?=site_url('topic/my_topics');?>">
								&gt;我的更多群话题...
							</a>
						</div>
						<?php endif; ?>
						
					</div>
					
					<div class="start_block">
						<h2>我的群活动</h2>
						
						<ul class="events_show">
						<?php 
							if ( !empty( $user_groups_events ) ):
							foreach( $user_groups_events as $event ) :
								$event_group = kk_get_group( $event['model_id'] );
								$event_user = kk_get_user( $event['user_id'] );
						?>
							<li>
								<div class="float_right">
									<span class="tipsy_s" title="作者:<?= $event_user['name'];?>">
										<a href="<?= get_user_url( $event_user['id'] );?>">
											<img width="24" src="<?= get_user_avatar_url( $event_user['id'] );?>" />
										</a>
									</span>
									
									<span class="tipsy_s" title="来自<?= $event_group['name'];?>">
										<a href="<?= get_group_url( $event_group['id'] );?>">
											<img width="24" src="<?= get_group_logo_url( $event_group['id'] );?>" />
										</a>
									</span>

								</div>
								
								<a href="<?=site_url('event/' . $event['id'] );?>">
									<?= $event['name'];?>
								</a>
								

							</li>
						<?php
							endforeach;
							else:
						?>
							<div class="grey align_center">
								<b>还没加入任何有活动的群...</b>
								<a href="<?=site_url('group');?>">
									->去看看
								</a>
							</div>
						<?php
							endif;
						?>
						</ul>
						
						<div class="clearboth"></div>
						
						<?php if ( !empty( $user_groups_events ) ) : ?>
						<div class="align_right">
							<a href="<?=site_url('event/my_events');?>">
								&gt;我的更多群活动...
							</a>
						</div>
						<?php endif; ?>
						
					</div>
					
					<div class="clearboth"></div>
					
				</div>
				
				
				<div class="clearboth"></div>
				
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
						<input class="mood_text" name="mood_text" value="今天心情怎样？" />
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
						<li>
							<span>
								<a href="<?= get_group_url( $group['id'] );?>">
									<span class="hover"></span>
									<img class="group_logo" width="18" src="<?= get_group_logo_url( $group['id'] );?>" />
									
									<?= $group['name'];?>
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
				

				
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>