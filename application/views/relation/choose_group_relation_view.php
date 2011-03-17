<?php
	// 本页面专门针对IE6
	$this->load->view('header_view');
?>
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				
				
				<div id="choose_group_relation"></div>
				
				<script>
					$('#choose_group_relation').load('<?=site_url("relation/ajax_choose_group_relation/" . $from_group_id . "?ajax=" .rand() );?>');
				</script>
				
			</div>
		</div>
	</div>

	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php
					$this->load->view('sidebar/sidebar_group_profile', array(
						'group' => $group,
					));
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