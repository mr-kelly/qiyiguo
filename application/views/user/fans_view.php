<?php
	$this->load->view('header_view');
?>


	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1><?=$user['name'];?>粉丝</h1>
				
				<div style="margin-bottom:20px;">
					<a href="<?=site_url('user/follows/' . $user_id );?>" class="kk_btn">
						收藏的人
					</a>
					<a href="<?=site_url('user/friends/' .  $user_id );?>" class="kk_btn">
						朋友
					</a>
				</div>
				
				<?php
					kk_pagination( $start, $fans_count, $per_page );
				?>
				
				<?php
					$this->load->view('general/general_users_table', array(
						'users' => $fans,
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
						'user' => $user,
					));
					
					$this->load->view('sidebar/sidebar_user_view', array(
						'user' => $user,
					));
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>