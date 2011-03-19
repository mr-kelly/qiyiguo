<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				
				<h1>我的群话题</h1>
				
				
				<?php
					kk_pagination( $start, $my_topics_count,  $per_page );
					$this->load->view('topic/general_topics_show', array(
						'topics' => $user_groups_topics,
					));
				?>
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>