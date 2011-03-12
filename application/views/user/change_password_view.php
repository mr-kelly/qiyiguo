<?php
	$this->load->view('header_view');
?>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>修改密码</h1>
			
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
				?>
			</div>
		</div>
	</div>


<?php
	$this->load->view('footer_view');
?>