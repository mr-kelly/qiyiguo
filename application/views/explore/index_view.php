<?php
	$this->load->view('header_view');
?>
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>探索奇异果</h1>
				
				<div class="explore_block">
					<h2>推荐果群</h2>
					
					<div class="clearboth"></div>
				</div>
				
				<div class="explore_block">
					<h2>新鲜果群</h2><!--最新的5个人以上的群..-->
					<ul class="groups_show">
					<?php
						if ( !empty( $fresh_groups ) ): 
							foreach( $fresh_groups as $group ) :
					?>
						<li>
							<div>
								<img src="<?=get_group_logo_url( $group['id'] );?>" width="40" />
							</div>
							<div>
								<?=$group['name'];?>
							</div>
						</li>
					<?php
							endforeach;
						endif;
					?>
					</ul>
					
					<div class="clearboth"></div>
				</div>
				
				
				<div class="explore_block">
					<h2>新鲜事</h2>
					<ul class="topics_show">
					<?php foreach ( $fresh_topics as $topic ) : ?>
						<li>
							<a href="<?=site_url( 'topic/' . $topic['id'] );?>">
								<?php
									if ( !empty( $topic['title'] ) ) :
								?>
									<?= $topic['title'];?>
								<?php
									else:
								?>
									<?= kk_content_preview( $topic['content'], 48 );?>
								<?php
									endif;
								?>
							</a>
							
						</li>
					<?php endforeach; ?>
					</ul>
					
					<div class="clearboth"></div>
				</div>
				
				<div class="explore_block">
					<h2>新鲜活动</h2>
					<ul class="events_show">
					<?php foreach( $fresh_events as $event ): ?>
						<li>
							<a href="<?=site_url('event/' . $event['id'] );?>">
								<?= $event['name']; ?>
							</a>
						</li>
					<?php endforeach; ?>
					</ul>
					
					<div class="clearboth"></div>
				</div>
				
			</div>
		</div>
	</div>


	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>