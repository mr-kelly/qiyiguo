<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
			
				<h2>事情</h2>
				<?php
					$this->load->view('event/general_events_show', array(
						'events' => $events,
					));
				?>
				
				
			</div>
		</div>
	</div>


<?php
	$this->load->view('footer_view');
?>