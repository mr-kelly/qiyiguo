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
					
					<h2>关系群 (<?=$relation_groups_count;?>)</h2>
					
					<ul class="groups_show">
					<?php
						if ( !empty( $relation_lookup_groups ) ):
							foreach( $relation_lookup_groups as $group ):
					?>
						<li>
							<div>
								<img width="18" src="<?= get_group_logo_url( $group['id'] );?>" />

								
								<?= $group['name'] ; ?>
								
								<?php if ( is_group_admin( $group_id, get_current_user_id() ) ): // 当前群组id管理员?>
								<a class="icon icon_delete" onclick="return delete_btn(this);" ajax="<?=site_url('relation/ajax_delete_group_relation/' . $group_id . '/' . $group['id'] );?>" href="#">
									删除关系
								</a>
								<?php endif;?>
							</div>
							
							
						</li>
					<?php 
							endforeach; 
						else:
					?>
						<div class="grey align_center">
							还没有关系群组
						</div>
					<?php
						endif;
					?>
					
					</ul>
					
					
					<div class="clearboth"></div>
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