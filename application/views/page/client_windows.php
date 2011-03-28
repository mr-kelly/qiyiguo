<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>奇异果Windows客户端</h1>
				
				<p>
					如果你是IE 6/7/8、遨游、360等等使用IE内核的浏览器，你将不能得到奇异果最完整的界面效果。
				</p>
				
				<p>
					所以嘛...
				</p>
				
				<ul>
					<li>
						装一个<a href="http://www.google.com/chrome">谷歌浏览器</a>或<a href="http://www.firefox.com">火狐浏览器</a>
					</li>
					<li>
						使用奇异果的Windows客户端，获得最佳的页面效果。
					</li>
				</ul>
				
				<div class="align_center">
					<a href="#" class="kk_btn">
						下载客户端
					</a>
				</div>
			
			
				
				<h3 style="margin-top: 100px;">你是苹果电脑Mac OS X系统的用户?</h3>
				
				<p>
					哈哈。你走运了，奇异果就是在Mac OS X上开发的。<a href="<?=site_url('page/client_macosx');?>">去获得最酷的奇异果Mac OS X客户端</a>
				</p>
			
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