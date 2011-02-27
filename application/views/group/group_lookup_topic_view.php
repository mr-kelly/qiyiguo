<?php 
	$this->load->view('header_view'); 
	$ci =& get_instance();
?>
	<? // import_js('js/app/group/group_lookup.js');?>
	
	<?=import_css('css/app/group/group_lookup.css');?>
	

	<script type="text/javascript">
		var $js_url_ajax_add_topic = '<?=site_url('topic/ajax_add_topic/group/' . $group['id'] );?>';
	</script>
	<?=import_js('js/app/group/group_lookup.js');?>
	
	
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<div id="lookup_head">
					<?php $this->load->view('group/general_group_lookup_head');?>
				</div>


				<div id="lookup_main">
						
						

						<?php $this->load->view('topic/general_topics_list'); ?>
	
				</div>
					
			</div>
		</div>
	</div><!-- End Content-->
	
	
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