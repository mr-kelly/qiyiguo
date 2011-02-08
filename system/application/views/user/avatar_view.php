<?php $this->load->view('header_view'); ?>




<div id="content">

	<div class="content_top">
		<div class="cotnent_bottom">

			<div class="form_div">
				<?=isset($page_message) ? $page_message : ''; ?>
				
				<form action="<?=site_url('user/avatar_upload');?>" method="post" enctype="multipart/form-data">
					<input type="file" name="userfile" size="20" />
					
					<input type="submit" />
				</form>
			</div>
			
			
		</div>
	</div>
</div>

<?php $this->load->view('footer_view'); ?>