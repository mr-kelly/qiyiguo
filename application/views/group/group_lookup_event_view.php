<?php
	$this->load->view('header_view');
?>
	<?php $ci =& get_instance(); ?>
	<? //import_css('css/app/group/group_lookup.css');?>
	
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
			
				<div id="lookup_head">
					<?php $this->load->view('group/general_group_lookup_head');?>
				</div>
				
				
				
				<div id="lookup_main">
					<?php if ( is_group_user( $group_id, get_current_user_id() ) ) : ?>
					<div>
						
						<a onclick="$('.add_event_div').toggle();return false;" href="#" title="对果群发话~" class="add_event_btn tipsy_s btn">
							<span><span>新活动▼</span></span>
						</a>
						
						<?php
							$this->load->view('event/ajax_add_event_view', array(
								'model' => 'group',
								'model_id' => $group['id'],
								'hidden' => true,
							));
						?>
					</div>
					<?php endif; ?>
					
					<?php
						$this->load->view('event/general_events_list');
					?>
					
					<div class="clearboth"></div>
					
					<?= kk_pagination( $start, $events_count, 10 ); ?>
					
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