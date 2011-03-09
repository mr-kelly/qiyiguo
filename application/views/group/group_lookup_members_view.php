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
					<table class="kk_table">
						<thead>
							<th>果号</th>
							<th>名字</th>
							<th>性别</th>
						</thead>
						<tbody>
						<?php foreach ( $group_members as $member ) : ?>
							<tr>
								<td>
									<?= $member['id'] ; ?>
								</td>
								<td>
									<img width="16" src="<?=get_user_avatar_url( $member['id'] );?>" />
									<a href="<?= get_user_url( $member['id'] );?>">
										<?= $member['name'] ;?>
									</a>
									<?php if ( is_group_admin( $group_id, $member['id'] ) ):?>
										<span title="管理者" class="tipsy_w icon icon_admin"></span>
									<?php endif; ?>
								</td>
								<td>
									<?= $member['gender'] == 'male' ? '男' : '女' ;?>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
						
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