<?php
	$this->load->view('header_view');
?>

<div id="content">
	<div class="content_top">
		<div class="content_bottom">
			
			
			<img width="100" src="<?=get_group_logo_url( $group['id'] );?>" />
			
			<p>你需要加入「<?=$group['name'];?>」?</p>
			
			<div class="form_div">
				<?php
					$this->load->view('group/general_join_group_view');
				?>
			</div>
		</div>
	</div>
</div>

<?php
	$this->load->view('footer_view');
?>