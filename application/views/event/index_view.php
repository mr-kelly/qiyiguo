<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h2>活动</h2>
				<ul class="events_list">
					<?php foreach( $events as $event ): ?>
					<li class="event">
						<h2>
							<a href="<?=site_url('event/' . $event['id']);?>">
								<?=$event['name'];?>
							</a>
						</h2>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php print_r( $events ); ?>
			</div>
		</div>
	</div>


<?php
	$this->load->view('footer_view');
?>