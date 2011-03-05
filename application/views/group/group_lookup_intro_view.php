<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<div id="lookup_head">
					<?php $this->load->view('group/general_group_lookup_head');?>
				</div>


				<div id="lookup_main">
						
					<h2>群组简介</h2>
					
					<div>
						<?= $group['intro'];?>
					</div>
					
					
				</div>
			</div>
		</div>
	</div>


<?php
	$this->load->view('footer_view');
?>