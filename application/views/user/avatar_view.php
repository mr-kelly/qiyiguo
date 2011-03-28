<?php $this->load->view('header_view'); ?>




<div id="content">

	<div class="content_top">
		<div class="content_bottom">
			<h2>修改您的头像
			<div class="form_div">
				<?=isset($page_message) ? $page_message : ''; ?>
				
				<form action="<?=site_url('user/avatar_upload');?>" method="post" enctype="multipart/form-data">
					<input type="file" name="userfile" size="20" />
					
					<input type="submit" value="上传" />
				</form>
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
				
				$this->load->view('sidebar/sidebar_ad_pic');
			?>
		</div>
	</div>
</div>

<?php $this->load->view('footer_view'); ?>