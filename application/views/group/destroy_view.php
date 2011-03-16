<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>确定要毁灭群组「<?=$group['name'];?>」？</h1>
				<p>
					一经删除，群组所有的话题、活动、成员列表都不可恢复，你确定吗？
				</p>
				<div class="align_center">
					<br /><br />
					<a id="destroy_btn" href="<?=site_url('group/destroy/'. $group['id'] . '/sure');?>" class="kk_btn">
						确定毁灭！
					</a>
				</div>
				
				<script>
					$(function(){
						$('#destroy_btn').click(function(){
							if ( !confirm('真的确定毁灭群组？？！！！') ) {
								return false;
							}
						});
					});
				</script>
				
			</div>
		</div>
	</div>

	
	
	<div id="sidebar">
		<?php
			$this->load->view('sidebar/sidebar_ad_pic');
		?>
	</div>
<?php
	$this->load->view('footer_view');
?>