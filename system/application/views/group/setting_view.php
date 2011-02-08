<?php $this->load->view('header_view'); ?>

	<div id="sidebar"><?php $this->load->view('sidebar/sidebar_group_view'); ?></div>
	
	<div id="content">
	
		<h2>友群标志</h2>
		
		<form action="<?=site_url('group/logo_upload/' . $group['id']);?>" method="post" enctype="multipart/form-data">
			<input type="file" name="userfile" size="20" />
			
			<input type="submit" />
		</form>
		
		
		
	</div>
	
	
	<div id="aside"></div>

<?php $this->load->view('footer_view'); ?>