<?php
	$this->load->view('header_view');
?>

	<?= import_js( 'js/kk.clipboard/kk.clipboard.min.js');?>
	
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">

				<h2>
					邀请用户加入
					<img width="16" src="<?=get_group_logo_url( $group['id'] );?>" />
					
					<a href="<?=site_url('group/' . $group['id'] );?>">
						<?= $group['name'];?>
					</a>
				</h2>
				
				<div>
					<?= $group['name'];?> 的网址是...
					
					<div>
						<input id="group_url_input" style="width: 300px;" type="text" value="<?=get_group_url( $group['id'] );?>" />
					
						<a id="group_url_copy_btn" class="kk_btn" href="#">复制网址</a>
					</div>
					<script>
						$(function(){
							$('#group_url_input').select();
							
							$.clipboardReady(function(){
							
								$( "#group_url_copy_btn" ).click(function(){
							
									$.clipboard( $('#group_url_input').val() );
							
									return false;
							
								});
							
							});
						});
					</script>
				</div>
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>


