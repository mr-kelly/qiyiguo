<?php
	$this->load->view('header_view');
?>
	<?=import_css('css/app/home/index.css');?>
	<?=import_css('css/app/user/logout.css');?>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<div id="logout_pic">
					<div id="logout_intro">
						奇异果介绍
					</div>
					
				</div>
				
				<div style="height: 800px;"></div>
				
			</div>
		</div>
	</div>
	
	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php
					$this->load->view('sidebar/sidebar_homepage');
				?>
			</div>
		</div>
	</div>


<?php
	$this->load->view('footer_view');
?>