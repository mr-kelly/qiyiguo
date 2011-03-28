<?php
	$this->load->view('header_view');
?>


	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1><?=$user['name'];?>的收藏</h1>
				
				<div style="margin-bottom:20px;">
					<a href="<?=site_url('user/fans/'.$user_id);?>" class="kk_btn">
						粉丝
					</a>
					<a href="<?=site_url('user/friends/'.$user_id);?>" class="kk_btn">
						朋友
					</a>
				</div>
				
				<?php
					$this->load->view('general/general_users_table', array(
						'users' => $follows,
					));
				?>
				
				
				<?php
					kk_pagination( $start, $follows_count, $per_page );
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
				?>
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>