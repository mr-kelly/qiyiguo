			<div class="join_event_div">
				<?php 
					// 用户未参加～显示参加、兴趣按钮
					$a_event_user = is_event_user( $event['id'], get_current_user_id() );
					if ( !$a_event_user  ) : 
				?>
				<a class="btn join_event_btn" href="<?=site_url('event/ajax_join_event/' . $event['id']);?>">
					<span><span>参加</span></span>
				</a>
				<a class="btn join_event_btn" href="<?=site_url('event/ajax_follow_event/' . $event['id']);?>">
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
				<a class="btn join_event_btn" href="<?=site_url('event/ajax_follow_event/' . $event['id'] . '/unfollow' );?>">
					<span><span>没兴趣了</span></span>
				</a>
				<?php endif; ?>
			</div>
			
				<script>
					$(function(){
						$('.join_event_btn').click(function(){
							$.getJSON( $(this).attr('href'), function(json){
								if ( json.status == 1 ) {
									$('.join_event_div').load( '<?=site_url("event/ajax_get_event_join_btn/" . $event["id"] );?>');
									kk_growl.success( json.info );
								} else {
									kk_growl.error( json.info );
								}
							});
							
							return false;
						});
					});
				</script>