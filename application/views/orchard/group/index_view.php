<?php
	$this->load->view('orchard/orchard_header_view');
?>

<h2>果群</h2>
<table class="kk_table">
	<thead>
		<tr>
			<th>群号</th>
			<th>群名</th>
			<th>认证</th>
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
			<td><?= $group['vouched'] ? '认证了' : '未认证';?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>



<?php
	$this->load->view('orchard/orchard_footer_view');
?>