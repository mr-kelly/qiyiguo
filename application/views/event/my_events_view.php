<?php
	$this->load->view('header_view');
?>
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>我的活动</h1>
				
				<?php
					kk_pagination( $start, $my_events_count,  $per_page );
					
					$this->load->view('event/general_events_showlist', array(
						'events' => $user_groups_events,
						'show_group_name' => true,
					));
				?>
			</div>
		</div>
	</div>


	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>