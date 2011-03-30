<?php
	$this->load->view('header_view');
?>
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>我的活动</h1>
				
				<h2>我参与的活动</h2>
				<div>
					<?php
						$this->load->view('event/general_events_showlist', array(
							'events' => $user_events,
						));
					?>
					<div class="clearboth"></div>
				</div>
				
				
				
				<h2>我的群活动</h2>
				<div class="grey">
					&gt;我所加入的群组的最新活动
				</div>
				
				<?php
					kk_pagination( $start, $my_events_count,  $per_page );
					
					$this->load->view('event/general_events_list', array(
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
					$this->load->view('sidebar/sidebar_user_profile', array(
						'user' => kk_get_user( get_current_user_id() ),
					));
					$this->load->view('sidebar/sidebar_user_view', array(
						'user' => kk_get_user( get_current_user_id() ),
					));
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>