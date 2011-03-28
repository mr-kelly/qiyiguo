<?php
	$this->load->view('header_view');
?>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				
				<h1>果群管理者条款</h1>
				
				<a class="kk_btn" onclick="window.close()" href="#">
					同意，返回
				</a>
				
				<div>
				
				</div>
				
				
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