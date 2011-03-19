<?php
	$this->load->view('header_view');
?>

	<?=import_css('css/app/event/event_lookup.css');?>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
			
				<div class="float_right">
					<?php
						$this->load->view('event/general_event_join_btn');
					?>
				</div>
				
				<h1><?=$event['name'];?></h1>
				

				
				
				<div class="form_div">
					<div>
						<span>
							<b>开始时间: </b>
						</span>
						<span><?=$event['start'];?></span>
					</div>
					
					<div>
						<span>
							<b>结束时间: </b>
						</span>
						<span><?=$event['end'];?></span>
					</div>
					
					<div>
						<p>
							<?=$event['content'];?>
						</p>
					</div>
					
					<div>
						<h3>
							<span class="icon"></span>
							<?= $event_join_users_count; ?>人参加
						</h3>
						
						
						<?php foreach ( $event_join_users as $user ) : ?>
							<a class="tipsy_s" title="<?=$user['name'];?>" href="<?=get_user_url($user['id']);?>">
								<img width="18" src="<?=get_user_avatar_url( $user['id'] ) ;?>" /> 
							</a>
						<?php endforeach; ?>
					</div>
					
					<div>
						<h3>
							<span class="icon"></span>
							<?= $event_users_count; ?>人关注
						</h3>
						
						
						<?php foreach ( $event_users as $user ) : ?>
							<a class="tipsy_s" title="<?=$user['name'];?>" href="<?=get_user_url($user['id']);?>">
								<img width="18" src="<?=get_user_avatar_url( $user['id'] ) ;?>" /> 
							</a>
						<?php endforeach; ?>
					</div>
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