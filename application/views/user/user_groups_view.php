<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<?php
					//print_r( $user_groups );
					//$groups = $user_groups;
				?>
				<h2><?=$user['name'];?>加入的群</h2>
				<div>
				<?php
					$this->load->view('group/general_groups_show', array(
						'groups' => $total_user_groups,
					));
				?>
				</div>
			
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
					
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>