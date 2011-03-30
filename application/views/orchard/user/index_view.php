<?php
	$this->load->view('orchard/orchard_header_view');
?>

<h2>查看用户</h2>

<table class="kk_table center">
	<thead>
		<tr>
			<th>果号</th>
			<th>真实姓名</th>
			<th>昵称</th>
			<th>认证</th>
			
			<th>操作</th>
		</tr>
	</thead>
	
	<tbody>
	<?php foreach( $users as $user ): ?>
		<tr>
			<td><?=$user['id'];?></td>
			<td>
				<img width="16" src="<?=get_user_avatar_url( $user['id'] );?>" />
				<?=$user['realname'];?>
			</td>
			<td>
				<?=$user['nickname'];?>
			</td>
			<td>
				<?= $user['vouched'] ? '认证' : '未认证';?>
			</td>
			
			<td>
				<a href="#">认证</a>
				<a href="#">删除</a>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php
	kk_pagination( $start, $users_count, 20 );
?>

<?php
	$this->load->view('orchard/orchard_footer_view');
?>
