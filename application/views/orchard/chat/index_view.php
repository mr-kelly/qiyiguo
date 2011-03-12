<?php
	$this->load->view('orchard/orchard_header_view');
?>

<div id="content">
	<h2>聊天</h2>
	<table class="kk_table">
		<thead>
			<tr>
				<th>编号</th>
				<th>内容</th>
				<th>作者</th>
			</tr>
		</thead>
		
		<tbody>
			<?php foreach( $chats as $chat ) : ?>
			<tr>
				<td><?=$chat['id'];?></td>
				<td>
					<?=$chat['content'];?>
				</td>
				<td>
					<?=$chat['user_id'];?>
				</td>
			</tr>
			
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<div class="align_center">
		<?= kk_pagination( $start, $chats_count, 20);?>
	</div>
</div>


<?php
	$this->load->view('orchard/orchard_footer_view');
?>