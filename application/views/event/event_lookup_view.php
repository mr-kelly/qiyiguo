<?php
	$this->load->view('header_view');
?>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1><?=$event['name'];?></h1>
				
				<?php
					$this->load->view('event/general_event_join_btn');
				?>
				
				
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
					<p>
						参加人数: <?= $event_join_users_count; ?>
						关注人数: <?= $event_users_count; ?>
					</p>
				</div>
				
				
				<!-- ajax 评论 -->
				<ul class="chats_container no_scroll" style="margin-left:10px; max-height:none;">
				
				</ul>
				
				<script>
					$(function(){
						$('.chats_container').load('<?=site_url("chat/ajax_get_chats/event/" . $event["id"] );?>');
					});
				</script>
				
				<?php //print_r( $event ); ?>
			</div>
		</div>
	</div>
	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				
				<?php
					$this->load->view('sidebar/sidebar_group_profile', array(
						'group' => $event['Group'],
					));
				?>
				
			</div>
		</div>
	</div>


<?php
	$this->load->view('footer_view');
?>