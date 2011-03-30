<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>选择一个你已加入的群组，点击“新活动”</h1>
				<?php
					$this->load->view('group/general_groups_show', array(
						'groups' => $add_events_user_groups,
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
						'user' => get_current_user_profile(),
					));
					$this->load->view('sidebar/sidebar_user_view', array(
						'user' => get_current_user_profile(),
					));
				?>
			</div>
		</div>
	</div>
	
	
	
<?php
	$this->load->view('footer_view');
?>