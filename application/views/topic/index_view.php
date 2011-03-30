<?php
	$this->load->view('header_view');
?>

	 <?=import_js('js/app/topic/general_topics_list.js');?>
	 

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>话题</h1>
				<div class="grey">
					&gt;这些是来自奇异果公开群组的最新话题，发现有没有你感兴趣的话题、群组呗。
				</div>
				<?php
					$this->load->view('topic/general_topics_list', array(
						'topics' => $topics,
						'show_group_logo' => true,
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