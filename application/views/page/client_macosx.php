<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>奇异果Mac OS X客户端</h1>
				
				<p>
					将「奇异果」挂到你的Dock上。
				</p>
				
				<div class="align_center">
					<a href="http://jiajiao.bnuep.com/t/download/mac_qiyiguo.cc.app.zip" class="kk_btn">
						下载客户端
					</a>
				</div>
			
			
				<h3>其它选择</h3>
				<div>
					<a href="<?site_url('page/client_windows');?>">
						&gt;奇异果Windows客户端
					</a>
				</div>
				
			</div>
		</div>
	</div>

	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php
					$this->load->view('sidebar/sidebar_group_profile', array(
						'group' => kk_get_group( 10000 ),
					));
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>
<?php
	$this->load->view('footer_view');
?>