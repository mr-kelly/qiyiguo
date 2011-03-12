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
						安全退出奇异果，欢迎下次在来哦！
						
						<a href="<?=site_url('/');?>" class="kk_btn">回到首页</a>
						
					</div>
					
				</div>

				<div id="home_show">
					
					
					<div class="home_block">
						<h2>推荐</h2>
					</div>
					
					<div class="home_block">
						<h2>赞助商链接</h2>
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
				
				<?php
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>


<?php
	$this->load->view('footer_view');
?>