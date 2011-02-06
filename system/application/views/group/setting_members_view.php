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
							<th>加入时间</th>
							<th>活跃度</th>
							<th>操作</th>
						</tr>
					</thead>
					
					<tbody>
					
					<?php foreach( $group_members as $user ): ?>
						<tr>
							<td><?=$user['id'];?></td>
							<td><?=get_user_name( $user['nickname'], $user['realname'] );?></td>
							<td>asd</td>
							<td>dafsadf</td>
							<td>驱赶 / 修改备注名</td>
						</tr>
					<?php endforeach; ?>
					
						<tr class="row2">
							<td>afsdaf</td>
							<td>dfsdfs</td>
							<td>dsafdsf</td>
							<td>dafsadf</td>
							<td>dsfsafsdf</td>
						</tr>
					</tbody>
				
				</table>
				<?=print_r( $group_members );?>
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>