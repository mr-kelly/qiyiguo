<?php
	$this->load->view('header_view');
?>

	<?=import_js('js/app/group/setting.js');?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h2>果群成员管理</h2>
				<?php
					kk_pagination( $start, $group_members_count, 20);
				?>
				
				<table class="kk_table">
					<thead>
						<tr>
							<th>果号</th>
							<th>用户</th>
							<!--<th>备注名</th>-->
							<!--<th>加入时间</th>-->
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
							<!--<td>备注名</td>-->
							<!--<td>...</td>-->
							<!--<td>dafsadf</td>-->
							<td>
							<script>

							</script>
								<?php
									// 非当前登录用户自己,才显示管理员设置项
									if ( get_current_user_id() != $user['id'] ) :
								?>
								
								<?php if ( !is_group_admin( $group['id'], $user['id'] ) ): ?>
								<a onclick="return set_group_user(this);" href="<?=site_url('group/ajax_set_group_admin/' . $group['id'] . '/'. $user['id'] );?>">
									提升为主人
								</a> /
								<?php else: ?>
									
									<?php if ( is_group_owner( $group['id'], get_current_user_id() ) ) : ?>
									<a onclick="return set_group_user(this);" href="<?=site_url('group/ajax_cancel_group_admin/' . $group['id'] . '/'. $user['id'] );?>">
										撤销主人
									</a> /
									<?php endif; ?>
									
								<?php endif; ?>
								
								<a onclick="return set_group_user(this);" class="tipsy_s" title="把他驱赶出群" href="<?=site_url('group/ajax_cancel_group_member/' . $group['id'] . '/' . $user['id'] );?>">
									驱赶
								</a>
								
								
								
								<?php
									endif;
								?>

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
				<?php
					$this->load->view('sidebar/sidebar_group_profile');
					
					$this->load->view('sidebar/sidebar_group_view');
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