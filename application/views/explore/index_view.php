<?php
	$this->load->view('header_view');
?>

	<?=import_css('css/app/explore/index.css');?>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>探索奇异果</h1>
				<div class="grey">
					<p>
						天天夜夜，总有很多事发生在你的周围。 
					</p>
					
					<p>
						奇异果让你发现生活中一切。 如果你还没发现，创造它。
					</p>
				</div>
				
				
				<div class="explore_block">
					<h2>推荐果群</h2>
					<?php
						$this->load->view('group/general_groups_show', array(
							'groups' => $random_groups,
						));
					?>
					<div class="clearboth"></div>
				</div>
				
				<div class="explore_block">
					<h2>新鲜果群</h2><!--最新的5个人以上的群..-->
					<?php
						$this->load->view('group/general_groups_show', array(
							'groups' => $fresh_groups,
						));
					?>
					
					
					<div class="clearboth"></div>
				</div>
				
				<div class="clearboth"></div>
				
				<div class="explore_block">
					<h2>新鲜事</h2>
					<?php
						$this->load->view('topic/general_topics_showlist', array(
							'topics' => $fresh_topics,
						));
					?>
					
					
					<div class="clearboth"></div>
				</div>
				
				<div class="explore_block">
					<h2>新鲜活动</h2>
					<?php
						$this->load->view('event/general_events_showlist', array(
							'events' => $fresh_events,
						));
					?>

					
					<div class="clearboth"></div>
				</div>
				
			</div>
		</div>
	</div>


	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
 						<?php 
							if ( is_logged_in() ):
								$this->load->view('sidebar/sidebar_user_profile', array(
									'user' => kk_get_user( get_current_user_id() ),
								)); 
								$this->load->view('sidebar/sidebar_user_view', array(
									'user' => kk_get_user( get_current_user_id() ),
								)); 
							endif;
						?>
						
            			<?php
            				$this->load->view('sidebar/sidebar_ad_pic');
            			?>
            			
            			<?php $this->load->view('sidebar/sidebar_group_view'); ?>
            			
            			
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>