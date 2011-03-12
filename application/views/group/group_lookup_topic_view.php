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
						
						<?php if ( is_group_admin( $group['id'], get_current_user_id() ) ) :?>
						<a onclick="$('.add_topic_div').toggle();return false;" title="对果群发话~" class="tipsy_s kk_btn add_topic_btn" href="#">
							发话▼
						</a>
						<div>
							<? // 放置 填写主题层 ?>
							<?php
								$this->load->view('topic/ajax_add_topic_view', array(
									'model' => 'group',
									'model_id' => $group['id'],
									'hidden' => true,
								));
							?>
						</div>
						<?php endif; ?>
						
						<?= kk_pagination( $start, $topics_count, 10);?>
						
						<?php $this->load->view('topic/general_topics_list'); ?>
						
						<?= kk_pagination( $start, $topics_count, 10);?>
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