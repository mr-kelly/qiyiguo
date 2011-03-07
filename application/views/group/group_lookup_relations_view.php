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
					
					<h2>关系群 (<?=$group_users_count;?>)</h2>
					
					<ul class="groups_show">
					<?php foreach( $relation_lookup_groups as $group ): ?>
						<li>
							<div>
								<img width="40" src="<?= get_group_logo_url( $group['id'] );?>" />
							</div>
							<div>
								
								<?= $group['name'] ; ?>
							</div>
						</li>
					<?php endforeach; ?>
					</ul>
						
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