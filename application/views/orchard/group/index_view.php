<?php
	$this->load->view('orchard/orchard_header_view');
?>

<h2>果群</h2>
<table class="kk_table center">
	<thead>
		<tr>
			<th>群号</th>
			<th>群名</th>
			<th>性质</th>
			<th>加入方式</th>
			<th>认证</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ( $groups as $group ) : ?>
		<tr>
			<td><?=$group['id'];?></td>
			<td>
				<img height="16" src="<?=get_group_logo_url( $group['id'] );?>" />
				<?=$group['name'];?>
			</td>
			<td><?=$group['privacy'];?></td>
			<td>
				<?=$group['verify'];?>
			</td>
			<td><?= $group['vouched'] ? '认证了' : '未认证';?></td>
			<td>
				<a href="<?=site_url('orchard/group/' . $group['id']);?>">查看详细</a>
				<a href="<?=site_url('orchard/group/delete/' . $group['id']);?>">删除</a>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>



<?php
	$this->load->view('orchard/orchard_footer_view');
?>
