<?php
	$this->load->view('orchard/orchard_header_view');
?>
	
	<div id="content">
		
		<table class="kk_table align_center">
			
			<thead>
				<tr>
					<th width="50">ID</th>
					<th width="150">标题</th>
					<th>内容</th>
					<th width="100">作者</th>
					<th width="200">操作</th>
				</tr>
			</thead>
			
			<tbody>
				<?php foreach( $topics as $topic ) : ?>
				<tr>
					<td>
						<?=$topic['id'];?>
					</td>
					
					<td>
						<?=$topic['title'];?>
					</td>
					<td>
						<?=kk_content_preview( $topic['content'] );?>
					</td>
					<td>
						<img width="16" src="<?=get_user_avatar_url( $topic['user_id'] );?>" />
						<?php
							$user = kk_get_user( $topic['user_id'] );
						?>
						<?= $user['realname'];?>
					</td>
					
					<td>
						<a href="#">
							修改
						</a>
						
						<a href="#">
							删除
						</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="align_center">
			<?= kk_pagination( $start, $topics_count, 20 ); ?>
		</div>
	
	</div>


<?php
	$this->load->view('orchard/orchard_footer_view');
?>