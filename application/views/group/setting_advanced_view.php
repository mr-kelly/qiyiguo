<?php $this->load->view('header_view'); ?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>高级功能</h1>
				
				<h2>群聊天（实验）</h2>
				<p>
					你可以在奇异果实现QQ群的集体即时聊天。
				</p>
				<div class="align_center">
					<a href="<?=site_url( 'group/' . $group_id . '/chat' );?>" class="kk_btn">
						&gt;群组聊天
					</a>
				</div>
			</div>
		</div>
	</div>
	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php
					$this->load->view('sidebar/sidebar_group_profile'); 
				?>
			</div>
		</div>
	</div>

<?php $this->load->view('footer_view'); ?>