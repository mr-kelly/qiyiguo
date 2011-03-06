<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h2>果群成员管理</h2>
				
				<table class="kk_table">
					<thead>
						<tr>
							<th>果号</th>
							<th>用户</th>
							<th>备注名</th>
							<th>加入时间</th>
							<!--<th>活跃度</th>-->
							<th>操作</th>
						</tr>
					</thead>
					
					<tbody>
					
					
					<?php
						$row = 1; // 用于双行、单行
						foreach( $group_members as $user ): 
					?>
						<tr <?= ( $row % 2 == 0 ) ? 'class="row2"' : '' ;?>>
							<td><?=$user['id'];?></td>
							<td>
								<a href="<?=get_user_url( $user['id'] );?>">
									<?=get_user_name( $user['nickname'], $user['realname'] );?>
								</a>
								<?php if ( is_group_admin( $group_id, $user['id'] ) ): ?>
									<span title="管理员" class="tipsy_e icon icon_admin"></span>
								<?php endif; ?>
								
							</td>
							<td>备注名</td>
							<td>...</td>
							<!--<td>dafsadf</td>-->
							<td>
								<a href="<?=site_url('group/ajax_set_group_admin/' . $group['id'] . '/'. $user['id'] );?>">
									提升为管理员
								</a>
								/ 驱赶 / 修改备注名</td>
						</tr>
					<?php 
						$row++;
						endforeach;
					?>
					
					</tbody>
				
				</table>
				<? //print_r( $group_members );?>
			</div>
		</div>
	</div>
	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>