<?php
	$this->load->view('header_view');
?>
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">

				<div>
					邀请用户加入
					<a href="<?=site_url('group/' . $group['id'] );?>">
						<?= $group['name'];?>
					</a>
				</div>
				
				<div>
					群的链接是...
					<a href="<?=get_group_url( $group['id'] );?>">
						<?=get_group_url( $group['id'] );?>
					</a>
				</div>
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>


