<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1><?=$event['name'];?></h1>
				
				<?php 
					// 用户未参加～显示参加、兴趣按钮
					$a_event_user = is_event_user( $event['id'], get_current_user_id() );
					if ( !$a_event_user  ) : 
				?>
				<a class="btn join_event_btn" href="<?=site_url('event/ajax_join_event/' . $event['id']);?>">
					<span><span>参加</span></span>
				</a>
				<a class="btn follow_event_btn" href="<?=site_url('event/ajax_follow_event/' . $event['id']);?>">
					<span><span>有兴趣</span></span>
				</a>
				<?php
					elseif ( $a_event_user == 'join' ):
					// 已加入?
				?>
				<a class="btn join_event_btn" href="<?=site_url('event/ajax_join_event/' . $event['id'] . '/exit');?>">
					<span><span>不参加了</span></span>
				</a>
				<?php
					elseif ( $a_event_user == 'follow' ):
					// 已经对其有兴趣？ 可以加入！
				?>
				<a class="btn join_event_btn" href="<?=site_url('event/ajax_join_event/' . $event['id']);?>">
					<span><span>参加</span></span>
				</a>
				<a class="btn follow_event_btn" href="<?=site_url('event/ajax_follow_event/' . $event['id'] . '/unfollow' );?>">
					<span><span>没兴趣了</span></span>
				</a>
				<?php endif; ?>
				
				<div class="form_div">
					<p>
						<label>开始时间:</label>
						<span><?=$event['start'];?></span>
					</p>
					
					<p>
						<label>结束时间:</label>
						<span><?=$event['end'];?></span>
					</p>
					
					<p>
						<?=$event['content'];?>
					</p>
				</div>
				
				<?php print_r( $event ); ?>
			</div>
		</div>
	</div>
	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php
					if ( $event['model'] == 'group' ):
				?>
				Group <?=$event['Group']['name'];?>
				<?php
					endif;
				?>
			</div>
		</div>
	</div>


<?php
	$this->load->view('footer_view');
?>