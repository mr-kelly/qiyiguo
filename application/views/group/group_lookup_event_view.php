<?php
	$this->load->view('header_view');
?>
	<?php $ci =& get_instance(); ?>
	<?=import_css('css/app/group/group_lookup.css');?>
	
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
			
				<div id="lookup_head">
					<?php $this->load->view('group/general_group_lookup_head');?>
				</div>
				
				
				
				<div id="lookup_main">
					<div>
					<?php
						$this->load->view('event/ajax_add_event_view');
					?>
					</div>
					
					<?php
						$this->load->view('event/general_events_list');
					?>
				</div>
				
				<div class="clearboth"></div>
				
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