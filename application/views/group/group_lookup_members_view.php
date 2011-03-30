<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<div id="lookup_head">
					<?php $this->load->view('group/general_group_lookup_head');?>
				</div>
				
				
				
				<div id="lookup_main">
					
					<h2>成员列表</h2>
					<?php
						$this->load->view('general/general_users_table', array(
							'users' => $group_members,
						));
					?>
						
						
					<div>
						<a href="#" class="icon icon_xls">导出Excel...(工程中)</a>
					</div>
					
				</div>
			</div>
		</div>
	</div>



	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php $this->load->view('sidebar/sidebar_group_view'); ?>
			</div>
		</div>
		
	</div>
<?php
	$this->load->view('footer_view');
?>