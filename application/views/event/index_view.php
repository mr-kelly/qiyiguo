<?php
	$this->load->view('header_view');
?>
	<?=import_css('css/app/event/index.css');?>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
			
				<h1>活动</h1>
				
				<div class="grey">
					&gt;这些是来自奇异果公开群组的活动集锦，看看有没有你想参加的。
				</div>
				<?php
					$this->load->view('event/general_events_list', array(
						'events' => $events,
					));
				?>
				
				
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